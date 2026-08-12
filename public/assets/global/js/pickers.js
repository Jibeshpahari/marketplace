(function () {
  const MONTHS = ["January","February","March","April","May","June","July","August","September","October","November","December"];
  const MONTHS_SHORT = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
  const WEEKDAYS = ["Su","Mo","Tu","We","Th","Fr","Sa"];
  const ITEM_H = 36;
  const REPEATS = 7;
  const MID = 3;

  function pad(n) { return String(n).padStart(2, "0"); }
  function toISODate(d) { return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`; }
  function fromISODate(str) {
    if (!str) return null;
    const [y, m, d] = str.split("-").map(Number);
    if (!y || !m || !d) return null;
    const date = new Date(y, m - 1, d);
    date.setHours(0, 0, 0, 0);
    return date;
  }
  function minuteStepFromInput(input) {
    const stepSec = parseInt(input.getAttribute("step"), 10);
    if (!stepSec || stepSec < 60) return 1;
    return Math.max(1, Math.round(stepSec / 60));
  }
  function nearestInArray(values, num) {
    let best = values[0], bd = Infinity;
    values.forEach(v => { const d = Math.abs(v - num); if (d < bd) { bd = d; best = v; } });
    return best;
  }

  function buildCalendarSkeleton() {
    return `
      <div class="dp-day-view">
        <div class="dp-header">
          <button type="button" class="dp-nav-btn dp-prev" aria-label="Previous month">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
          </button>
          <div class="dp-month-year">
            <button type="button" class="dp-select-btn dp-month-btn"></button>
            <button type="button" class="dp-select-btn dp-year-btn"></button>
          </div>
          <button type="button" class="dp-nav-btn dp-next" aria-label="Next month">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 6l6 6-6 6"/></svg>
          </button>
        </div>
        <div class="dp-weekdays"></div>
        <div class="dp-days"></div>
      </div>
      <div class="dp-month-view dp-hidden">
        <div class="dp-header">
          <button type="button" class="dp-nav-btn dp-month-view-back" aria-label="Back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
          </button>
          <button type="button" class="dp-select-btn dp-month-view-year" style="cursor:default;"></button>
          <div style="width:30px"></div>
        </div>
        <div class="dp-year-grid dp-month-grid"></div>
      </div>
      <div class="dp-year-view dp-hidden">
        <div class="dp-header">
          <button type="button" class="dp-nav-btn dp-year-prev-range" aria-label="Earlier years">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
          </button>
          <span class="dp-year-range" style="font-size:14px;font-weight:600;"></span>
          <button type="button" class="dp-nav-btn dp-year-next-range" aria-label="Later years">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 6l6 6-6 6"/></svg>
          </button>
        </div>
        <div class="dp-year-grid"></div>
      </div>
    `;
  }

  function bindCalendarEls(panel) {
    return {
      dayView: panel.querySelector(".dp-day-view"),
      monthView: panel.querySelector(".dp-month-view"),
      yearView: panel.querySelector(".dp-year-view"),
      monthBtn: panel.querySelector(".dp-month-btn"),
      yearBtn: panel.querySelector(".dp-year-btn"),
      weekdays: panel.querySelector(".dp-weekdays"),
      days: panel.querySelector(".dp-days"),
      prev: panel.querySelector(".dp-prev"),
      next: panel.querySelector(".dp-next"),
      monthGrid: panel.querySelector(".dp-month-grid"),
      monthViewYear: panel.querySelector(".dp-month-view-year"),
      monthViewBack: panel.querySelector(".dp-month-view-back"),
      yearGrid: panel.querySelector(".dp-year-view .dp-year-grid"),
      yearRangeLabel: panel.querySelector(".dp-year-range"),
      yearPrevRange: panel.querySelector(".dp-year-prev-range"),
      yearNextRange: panel.querySelector(".dp-year-next-range")
    };
  }

  function DatePicker(input) {
    this.input = input;
    this.today = new Date();
    this.today.setHours(0, 0, 0, 0);
    this.selected = fromISODate(input.value);
    this.view = new Date(this.selected || this.today);
    this.minDate = fromISODate(input.getAttribute("min"));
    this.maxDate = fromISODate(input.getAttribute("max"));
    this.yearRangeStart = Math.floor(this.view.getFullYear() / 12) * 12;
    this._buildPanel();
    this._bindInput();
  }

  DatePicker.prototype._buildPanel = function () {
    const panel = document.createElement("div");
    panel.className = "dp-panel";
    panel.innerHTML = buildCalendarSkeleton() + `
      <div class="dp-footer">
        <button type="button" class="dp-today-link">Today</button>
        <button type="button" class="dp-clear-link">Clear</button>
      </div>
    `;
    document.body.appendChild(panel);
    this.panel = panel;
    this.els = bindCalendarEls(panel);
    this.els.todayBtn = panel.querySelector(".dp-today-link");
    this.els.clearBtn = panel.querySelector(".dp-clear-link");

    this.els.weekdays.innerHTML = WEEKDAYS.map(w => `<div class="dp-weekday">${w}</div>`).join("");

    this.els.prev.addEventListener("click", () => { this.view.setMonth(this.view.getMonth() - 1); this.renderDays(); });
    this.els.next.addEventListener("click", () => { this.view.setMonth(this.view.getMonth() + 1); this.renderDays(); });

    this.els.monthBtn.addEventListener("click", () => { this._showView("month"); this.renderMonthGrid(); });
    this.els.monthViewBack.addEventListener("click", () => this._showView("day"));
    this.els.yearBtn.addEventListener("click", () => {
      this.yearRangeStart = Math.floor(this.view.getFullYear() / 12) * 12;
      this._showView("year");
      this.renderYearGrid();
    });
    this.els.yearPrevRange.addEventListener("click", () => { this.yearRangeStart -= 12; this.renderYearGrid(); });
    this.els.yearNextRange.addEventListener("click", () => { this.yearRangeStart += 12; this.renderYearGrid(); });

    this.els.todayBtn.addEventListener("click", () => {
      this.view = new Date(this.today);
      this._selectDate(new Date(this.today));
      this.close();
    });
    this.els.clearBtn.addEventListener("click", () => {
      this.selected = null;
      this._writeValue();
      this.renderDays();
    });

    panel.addEventListener("mousedown", (e) => e.stopPropagation());
  };

  DatePicker.prototype._showView = function (which) {
    this.els.dayView.classList.toggle("dp-hidden", which !== "day");
    this.els.monthView.classList.toggle("dp-hidden", which !== "month");
    this.els.yearView.classList.toggle("dp-hidden", which !== "year");
  };

  DatePicker.prototype._isDisabled = function (date) {
    if (this.minDate && date < this.minDate) return true;
    if (this.maxDate && date > this.maxDate) return true;
    return false;
  };
  DatePicker.prototype._sameDay = function (a, b) {
    return a && b && a.getFullYear() === b.getFullYear() && a.getMonth() === b.getMonth() && a.getDate() === b.getDate();
  };

  DatePicker.prototype.renderDays = function () {
    const year = this.view.getFullYear();
    const month = this.view.getMonth();
    this.els.monthBtn.textContent = MONTHS[month];
    this.els.yearBtn.textContent = year;

    const firstDay = new Date(year, month, 1);
    const startOffset = firstDay.getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();

    let html = "";
    for (let i = startOffset - 1; i >= 0; i--) {
      const d = daysInPrevMonth - i;
      html += `<button type="button" class="dp-day dp-day-outside" data-nav="prev" data-day="${d}">${d}</button>`;
    }
    for (let d = 1; d <= daysInMonth; d++) {
      const date = new Date(year, month, d);
      const classes = ["dp-day"];
      if (this._sameDay(date, this.today)) classes.push("dp-day-today");
      if (this.selected && this._sameDay(date, this.selected)) classes.push("dp-day-selected");
      if (this._isDisabled(date)) classes.push("dp-day-disabled");
      html += `<button type="button" class="${classes.join(" ")}" data-day="${d}">${d}</button>`;
    }
    const totalCells = startOffset + daysInMonth;
    const trailing = (7 - (totalCells % 7)) % 7;
    for (let d = 1; d <= trailing; d++) {
      html += `<button type="button" class="dp-day dp-day-outside" data-nav="next" data-day="${d}">${d}</button>`;
    }
    this.els.days.innerHTML = html;

    this.els.days.querySelectorAll(".dp-day").forEach(btn => {
      btn.addEventListener("click", () => {
        if (btn.classList.contains("dp-day-disabled")) return;
        const day = parseInt(btn.dataset.day, 10);
        const nav = btn.dataset.nav;
        const target = new Date(this.view);
        if (nav === "prev") target.setMonth(target.getMonth() - 1);
        else if (nav === "next") target.setMonth(target.getMonth() + 1);
        target.setDate(day);
        this.view = new Date(target);
        this._selectDate(target);
        this.close();
      });
    });
  };

  DatePicker.prototype._selectDate = function (date) {
    date.setHours(0, 0, 0, 0);
    this.selected = date;
    this._writeValue();
    this.renderDays();
  };
  DatePicker.prototype._writeValue = function () {
    this.input.value = this.selected ? toISODate(this.selected) : "";
    this.input.dispatchEvent(new Event("input", { bubbles: true }));
    this.input.dispatchEvent(new Event("change", { bubbles: true }));
  };

  DatePicker.prototype.renderMonthGrid = function () {
    this.els.monthViewYear.textContent = this.view.getFullYear();
    let html = "";
    MONTHS_SHORT.forEach((m, i) => {
      const active = i === this.view.getMonth() ? "active" : "";
      html += `<button type="button" class="dp-month-cell ${active}" data-month="${i}">${m}</button>`;
    });
    this.els.monthGrid.innerHTML = html;
    this.els.monthGrid.querySelectorAll(".dp-month-cell").forEach(btn => {
      btn.addEventListener("click", () => {
        this.view.setMonth(parseInt(btn.dataset.month, 10));
        this._showView("day");
        this.renderDays();
      });
    });
  };

  DatePicker.prototype.renderYearGrid = function () {
    this.els.yearRangeLabel.textContent = `${this.yearRangeStart} - ${this.yearRangeStart + 11}`;
    let html = "";
    for (let y = this.yearRangeStart; y < this.yearRangeStart + 12; y++) {
      const active = y === this.view.getFullYear() ? "active" : "";
      html += `<button type="button" class="dp-year-cell ${active}" data-year="${y}">${y}</button>`;
    }
    this.els.yearGrid.innerHTML = html;
    this.els.yearGrid.querySelectorAll(".dp-year-cell").forEach(btn => {
      btn.addEventListener("click", () => {
        this.view.setFullYear(parseInt(btn.dataset.year, 10));
        this._showView("day");
        this.renderDays();
      });
    });
  };

  DatePicker.prototype._position = function () {
    const rect = this.input.getBoundingClientRect();
    const panelWidth = 300;
    let left = rect.left + window.scrollX;
    const maxLeft = window.scrollX + document.documentElement.clientWidth - panelWidth - 8;
    if (left > maxLeft) left = Math.max(8, maxLeft);
    this.panel.style.left = `${left}px`;
    this.panel.style.top = `${rect.bottom + window.scrollY + 8}px`;
  };

  DatePicker.prototype._bindInput = function () {
    this.input.addEventListener("mousedown", (e) => { e.preventDefault(); this.input.focus(); this.toggle(); });
    this.input.addEventListener("keydown", (e) => {
      if (["Enter", " ", "ArrowDown"].includes(e.key)) { e.preventDefault(); this.open(); }
      else if (e.key === "Escape") this.close();
      else e.preventDefault();
    });
    document.addEventListener("mousedown", (e) => {
      if (!this.panel.classList.contains("open")) return;
      if (e.target === this.input) return;
      if (!this.panel.contains(e.target)) this.close();
    });
    window.addEventListener("scroll", () => { if (this.panel.classList.contains("open")) this._position(); }, true);
    window.addEventListener("resize", () => { if (this.panel.classList.contains("open")) this._position(); });
  };

  DatePicker.prototype.toggle = function () { this.panel.classList.contains("open") ? this.close() : this.open(); };
  DatePicker.prototype.open = function () {
    this.selected = fromISODate(this.input.value);
    this.view = new Date(this.selected || this.today);
    this._showView("day");
    this.renderDays();
    this._position();
    this.panel.classList.add("open");
  };
  DatePicker.prototype.close = function () { this.panel.classList.remove("open"); };

  function TimeWheel(container, opts) {
    this.container = container;
    this.minuteStep = opts.minuteStep || 1;
    this.hour = opts.hour;
    this.minute = opts.minute;
    this.onChange = opts.onChange || function () {};
    this.hourValues = Array.from({ length: 24 }, (_, i) => i);
    this.minuteValues = [];
    for (let m = 0; m < 60; m += this.minuteStep) this.minuteValues.push(m);
    this._taBuffer = "";
    this._taKind = null;
    this._build();
  }

  TimeWheel.prototype._renderItems = function (values) {
    let html = "";
    for (let r = 0; r < REPEATS; r++) {
      values.forEach(v => { html += `<button type="button" class="dp-time-item" data-val="${v}">${pad(v)}</button>`; });
    }
    return html;
  };

  TimeWheel.prototype._build = function () {
    this.container.innerHTML = `
      <div class="dp-time-row">
        <div class="dp-time-col-wrap">
          <button type="button" class="dp-time-arrow dp-hour-up" aria-label="Previous hour">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 15l-6-6-6 6"/></svg>
          </button>
          <div class="dp-time-col-viewport">
            <div class="dp-time-col-band"></div>
            <div class="dp-time-col dp-hour-col" tabindex="0" role="listbox" aria-label="Hour, 24 hour format"></div>
          </div>
          <button type="button" class="dp-time-arrow dp-hour-down" aria-label="Next hour">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
          </button>
        </div>
        <div class="dp-time-sep">:</div>
        <div class="dp-time-col-wrap">
          <button type="button" class="dp-time-arrow dp-minute-up" aria-label="Previous minute">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 15l-6-6-6 6"/></svg>
          </button>
          <div class="dp-time-col-viewport">
            <div class="dp-time-col-band"></div>
            <div class="dp-time-col dp-minute-col" tabindex="0" role="listbox" aria-label="Minute"></div>
          </div>
          <button type="button" class="dp-time-arrow dp-minute-down" aria-label="Next minute">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
          </button>
        </div>
      </div>
    `;

    this.hourCol = this.container.querySelector(".dp-hour-col");
    this.minuteCol = this.container.querySelector(".dp-minute-col");
    this.hourCol.innerHTML = this._renderItems(this.hourValues);
    this.minuteCol.innerHTML = this._renderItems(this.minuteValues);

    this.hourCol.querySelectorAll(".dp-time-item").forEach(btn => {
      btn.addEventListener("click", () => this._setHour(parseInt(btn.dataset.val, 10), true));
    });
    this.minuteCol.querySelectorAll(".dp-time-item").forEach(btn => {
      btn.addEventListener("click", () => this._setMinute(parseInt(btn.dataset.val, 10), true));
    });

    this.container.querySelector(".dp-hour-up").addEventListener("click", () => this._step("hour", -1));
    this.container.querySelector(".dp-hour-down").addEventListener("click", () => this._step("hour", 1));
    this.container.querySelector(".dp-minute-up").addEventListener("click", () => this._step("minute", -1));
    this.container.querySelector(".dp-minute-down").addEventListener("click", () => this._step("minute", 1));

    this.hourCol.addEventListener("scroll", () => this._onScroll("hour"));
    this.minuteCol.addEventListener("scroll", () => this._onScroll("minute"));

    this.hourCol.addEventListener("keydown", (e) => this._onKeydown(e, "hour"));
    this.minuteCol.addEventListener("keydown", (e) => this._onKeydown(e, "minute"));

    this.setValue(this.hour, this.minute, true);
  };

  TimeWheel.prototype._onKeydown = function (e, kind) {
    if (e.key === "ArrowUp") { e.preventDefault(); this._step(kind, -1); }
    else if (e.key === "ArrowDown") { e.preventDefault(); this._step(kind, 1); }
    else if (e.key === "Home") { e.preventDefault(); const values = kind === "hour" ? this.hourValues : this.minuteValues; if (kind === "hour") this._setHour(values[0], true); else this._setMinute(values[0], true); }
    else if (e.key === "End") { e.preventDefault(); const values = kind === "hour" ? this.hourValues : this.minuteValues; if (kind === "hour") this._setHour(values[values.length - 1], true); else this._setMinute(values[values.length - 1], true); }
    else if (/^[0-9]$/.test(e.key)) { e.preventDefault(); this._typeahead(kind, e.key); }
  };

  TimeWheel.prototype._typeahead = function (kind, digit) {
    clearTimeout(this._taTimer);
    this._taBuffer = (this._taKind === kind ? this._taBuffer : "") + digit;
    this._taKind = kind;
    const num = parseInt(this._taBuffer, 10);
    const commit = () => {
      if (kind === "hour") this._setHour(nearestInArray(this.hourValues, Math.min(num, 23)), true);
      else this._setMinute(nearestInArray(this.minuteValues, Math.min(num, 59)), true);
      this._taBuffer = "";
    };
    const canExtend = kind === "hour" ? num <= 2 : num <= 5;
    if (this._taBuffer.length >= 2 || !canExtend) commit();
    else this._taTimer = setTimeout(commit, 500);
  };

  TimeWheel.prototype._step = function (kind, delta) {
    const values = kind === "hour" ? this.hourValues : this.minuteValues;
    const cur = kind === "hour" ? this.hour : this.minute;
    let idx = values.indexOf(cur);
    if (idx < 0) idx = 0;
    idx = (idx + delta + values.length) % values.length;
    const val = values[idx];
    if (kind === "hour") this._setHour(val, true);
    else this._setMinute(val, true);
  };

  TimeWheel.prototype._onScroll = function (kind) {
    const col = kind === "hour" ? this.hourCol : this.minuteCol;
    clearTimeout(col._t);
    col._t = setTimeout(() => {
      const values = kind === "hour" ? this.hourValues : this.minuteValues;
      const items = [...col.querySelectorAll(".dp-time-item")];
      const center = col.scrollTop + col.clientHeight / 2;
      let closestIdx = 0, closestDist = Infinity;
      items.forEach((item, idx) => {
        const c = item.offsetTop + item.offsetHeight / 2;
        const d = Math.abs(c - center);
        if (d < closestDist) { closestDist = d; closestIdx = idx; }
      });
      const perBlock = values.length;
      const blockIndex = Math.floor(closestIdx / perBlock);
      const valIndex = closestIdx % perBlock;
      const val = values[valIndex];
      if (kind === "hour") this._setHour(val, false); else this._setMinute(val, false);
      if (blockIndex !== MID) col.scrollTop += (MID - blockIndex) * perBlock * ITEM_H;
    }, 120);
  };

  TimeWheel.prototype._highlight = function (col, val) {
    col.querySelectorAll(".dp-time-item").forEach(item => {
      item.classList.toggle("active", parseInt(item.dataset.val, 10) === val);
    });
  };

  TimeWheel.prototype._itemAt = function (col, values, blockIndex, val) {
    const idx = values.indexOf(val);
    const flatIndex = blockIndex * values.length + idx;
    return col.querySelectorAll(".dp-time-item")[flatIndex];
  };

  TimeWheel.prototype._scrollToVal = function (col, values, val, smooth) {
    const item = this._itemAt(col, values, MID, val);
    if (!item) return;
    const target = item.offsetTop + item.offsetHeight / 2 - col.clientHeight / 2;
    col.scrollTo({ top: target, behavior: smooth ? "smooth" : "auto" });
  };

  TimeWheel.prototype._setHour = function (val, scroll) {
    this.hour = val;
    this._highlight(this.hourCol, val);
    this._emit();
    if (scroll) this._scrollToVal(this.hourCol, this.hourValues, val, true);
  };

  TimeWheel.prototype._setMinute = function (val, scroll) {
    this.minute = val;
    this._highlight(this.minuteCol, val);
    this._emit();
    if (scroll) this._scrollToVal(this.minuteCol, this.minuteValues, val, true);
  };

  TimeWheel.prototype._emit = function () { this.onChange(this.hour, this.minute); };

  TimeWheel.prototype.setValue = function (hour, minute, silent) {
    this.hour = hour;
    this.minute = nearestInArray(this.minuteValues, minute);
    this._highlight(this.hourCol, this.hour);
    this._highlight(this.minuteCol, this.minute);
    this._scrollToVal(this.hourCol, this.hourValues, this.hour, false);
    this._scrollToVal(this.minuteCol, this.minuteValues, this.minute, false);
    if (!silent) this._emit();
  };

  function TimePicker(input) {
    this.input = input;
    this.minuteStep = minuteStepFromInput(input);
    const now = new Date();
    const parsed = this._parseValue(input.value);
    this.hour = parsed ? parsed.hour : now.getHours();
    this.minute = parsed ? parsed.minute : now.getMinutes() - (now.getMinutes() % this.minuteStep);
    this._buildPanel();
    this._bindInput();
  }

  TimePicker.prototype._parseValue = function (val) {
    if (!val) return null;
    const [h, m] = val.split(":").map(Number);
    if (isNaN(h) || isNaN(m)) return null;
    return { hour: h, minute: m };
  };

  TimePicker.prototype._buildPanel = function () {
    const panel = document.createElement("div");
    panel.className = "dp-panel";
    panel.innerHTML = `
      <div class="dp-time-display"></div>
      <div class="dp-time-section"></div>
      <div class="dp-footer">
        <div class="dp-footer-left">
          <button type="button" class="dp-today-link dp-now">Now</button>
          <button type="button" class="dp-clear-link dp-clear">Clear</button>
        </div>
        <button type="button" class="dp-done-btn">Done</button>
      </div>
    `;
    document.body.appendChild(panel);
    this.panel = panel;
    this.display = panel.querySelector(".dp-time-display");

    this.wheel = new TimeWheel(panel.querySelector(".dp-time-section"), {
      hour: this.hour,
      minute: this.minute,
      minuteStep: this.minuteStep,
      onChange: (h, m) => { this.hour = h; this.minute = m; this._updateDisplay(); this._writeValue(); }
    });
    this._updateDisplay();

    panel.querySelector(".dp-now").addEventListener("click", () => {
      const now = new Date();
      this.hour = now.getHours();
      this.minute = now.getMinutes() - (now.getMinutes() % this.minuteStep);
      this.wheel.setValue(this.hour, this.minute, true);
      this._updateDisplay();
      this._writeValue();
    });
    panel.querySelector(".dp-clear").addEventListener("click", () => {
      this.input.value = "";
      this.input.dispatchEvent(new Event("input", { bubbles: true }));
      this.input.dispatchEvent(new Event("change", { bubbles: true }));
      this.close();
    });
    panel.querySelector(".dp-done-btn").addEventListener("click", () => this.close());
    panel.addEventListener("mousedown", (e) => e.stopPropagation());
  };

  TimePicker.prototype._updateDisplay = function () {
    this.display.textContent = `${pad(this.hour)}:${pad(this.minute)}`;
  };
  TimePicker.prototype._writeValue = function () {
    this.input.value = `${pad(this.hour)}:${pad(this.minute)}`;
    this.input.dispatchEvent(new Event("input", { bubbles: true }));
    this.input.dispatchEvent(new Event("change", { bubbles: true }));
  };
  TimePicker.prototype._position = function () {
    const rect = this.input.getBoundingClientRect();
    const panelWidth = 300;
    let left = rect.left + window.scrollX;
    const maxLeft = window.scrollX + document.documentElement.clientWidth - panelWidth - 8;
    if (left > maxLeft) left = Math.max(8, maxLeft);
    this.panel.style.left = `${left}px`;
    this.panel.style.top = `${rect.bottom + window.scrollY + 8}px`;
  };
  TimePicker.prototype._bindInput = function () {
    this.input.addEventListener("mousedown", (e) => { e.preventDefault(); this.input.focus(); this.toggle(); });
    this.input.addEventListener("keydown", (e) => {
      if (["Enter", " ", "ArrowDown"].includes(e.key)) { e.preventDefault(); this.open(); }
      else if (e.key === "Escape") this.close();
      else e.preventDefault();
    });
    document.addEventListener("mousedown", (e) => {
      if (!this.panel.classList.contains("open")) return;
      if (e.target === this.input) return;
      if (!this.panel.contains(e.target)) this.close();
    });
    window.addEventListener("scroll", () => { if (this.panel.classList.contains("open")) this._position(); }, true);
    window.addEventListener("resize", () => { if (this.panel.classList.contains("open")) this._position(); });
  };
  TimePicker.prototype.toggle = function () { this.panel.classList.contains("open") ? this.close() : this.open(); };
  TimePicker.prototype.open = function () {
    const parsed = this._parseValue(this.input.value);
    if (parsed) { this.hour = parsed.hour; this.minute = parsed.minute; }
    this.wheel.setValue(this.hour, this.minute, true);
    this._updateDisplay();
    this._position();
    this.panel.classList.add("open");
  };
  TimePicker.prototype.close = function () { this.panel.classList.remove("open"); };

  function DateTimePicker(input) {
    this.input = input;
    this.minuteStep = minuteStepFromInput(input);
    this.today = new Date(); this.today.setHours(0, 0, 0, 0);
    const now = new Date();
    const parsed = this._parseValue(input.value);
    this.selectedDate = parsed ? parsed.date : null;
    this.view = new Date(parsed ? parsed.date : this.today);
    this.hour = parsed ? parsed.hour : now.getHours();
    this.minute = parsed ? parsed.minute : now.getMinutes() - (now.getMinutes() % this.minuteStep);
    this.minDate = fromISODate((input.getAttribute("min") || "").split("T")[0]);
    this.maxDate = fromISODate((input.getAttribute("max") || "").split("T")[0]);
    this.yearRangeStart = Math.floor(this.view.getFullYear() / 12) * 12;
    this._buildPanel();
    this._bindInput();
  }

  DateTimePicker.prototype._parseValue = function (val) {
    if (!val) return null;
    const [datePart, timePart] = val.split("T");
    const date = fromISODate(datePart);
    if (!date || !timePart) return null;
    const [h, m] = timePart.split(":").map(Number);
    return { date, hour: h, minute: m };
  };

  DateTimePicker.prototype._buildPanel = function () {
    const panel = document.createElement("div");
    panel.className = "dp-panel dp-panel-dt";
    panel.innerHTML = `
      <div class="dp-dt-layout">
        <div class="dp-dt-calendar">
          ${buildCalendarSkeleton()}
        </div>
        <div class="dp-dt-divider"></div>
        <div class="dp-dt-time">
          <div class="dp-time-display"></div>
          <div class="dp-time-cols"></div>
        </div>
      </div>
      <div class="dp-footer">
        <div class="dp-footer-left">
          <button type="button" class="dp-today-link dp-now">Now</button>
          <button type="button" class="dp-clear-link dp-clear">Clear</button>
        </div>
        <button type="button" class="dp-done-btn">Done</button>
      </div>
    `;
    document.body.appendChild(panel);
    this.panel = panel;
    this.display = panel.querySelector(".dp-time-display");
    this.els = bindCalendarEls(panel);

    this.els.weekdays.innerHTML = WEEKDAYS.map(w => `<div class="dp-weekday">${w}</div>`).join("");

    this.els.prev.addEventListener("click", () => { this.view.setMonth(this.view.getMonth() - 1); this.renderDays(); });
    this.els.next.addEventListener("click", () => { this.view.setMonth(this.view.getMonth() + 1); this.renderDays(); });
    this.els.monthBtn.addEventListener("click", () => { this._showView("month"); this.renderMonthGrid(); });
    this.els.monthViewBack.addEventListener("click", () => this._showView("day"));
    this.els.yearBtn.addEventListener("click", () => {
      this.yearRangeStart = Math.floor(this.view.getFullYear() / 12) * 12;
      this._showView("year");
      this.renderYearGrid();
    });
    this.els.yearPrevRange.addEventListener("click", () => { this.yearRangeStart -= 12; this.renderYearGrid(); });
    this.els.yearNextRange.addEventListener("click", () => { this.yearRangeStart += 12; this.renderYearGrid(); });

    this.wheel = new TimeWheel(panel.querySelector(".dp-time-cols"), {
      hour: this.hour,
      minute: this.minute,
      minuteStep: this.minuteStep,
      onChange: (h, m) => { this.hour = h; this.minute = m; this._updateDisplay(); this._writeValue(); }
    });

    panel.querySelector(".dp-now").addEventListener("click", () => {
      const now = new Date();
      this.selectedDate = new Date(this.today);
      this.view = new Date(this.today);
      this.hour = now.getHours();
      this.minute = now.getMinutes() - (now.getMinutes() % this.minuteStep);
      this.wheel.setValue(this.hour, this.minute, true);
      this._updateDisplay();
      this.renderDays();
      this._writeValue();
    });
    panel.querySelector(".dp-clear").addEventListener("click", () => {
      this.selectedDate = null;
      this.input.value = "";
      this.input.dispatchEvent(new Event("input", { bubbles: true }));
      this.input.dispatchEvent(new Event("change", { bubbles: true }));
      this.renderDays();
      this.close();
    });
    panel.querySelector(".dp-done-btn").addEventListener("click", () => this.close());
    panel.addEventListener("mousedown", (e) => e.stopPropagation());

    this._updateDisplay();
  };

  DateTimePicker.prototype._updateDisplay = function () {
    this.display.textContent = `${pad(this.hour)}:${pad(this.minute)}`;
  };
  DateTimePicker.prototype._showView = function (which) {
    this.els.dayView.classList.toggle("dp-hidden", which !== "day");
    this.els.monthView.classList.toggle("dp-hidden", which !== "month");
    this.els.yearView.classList.toggle("dp-hidden", which !== "year");
  };
  DateTimePicker.prototype._isDisabled = function (date) {
    if (this.minDate && date < this.minDate) return true;
    if (this.maxDate && date > this.maxDate) return true;
    return false;
  };
  DateTimePicker.prototype._sameDay = function (a, b) {
    return a && b && a.getFullYear() === b.getFullYear() && a.getMonth() === b.getMonth() && a.getDate() === b.getDate();
  };

  DateTimePicker.prototype.renderDays = function () {
    const year = this.view.getFullYear();
    const month = this.view.getMonth();
    this.els.monthBtn.textContent = MONTHS[month];
    this.els.yearBtn.textContent = year;

    const firstDay = new Date(year, month, 1);
    const startOffset = firstDay.getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();

    let html = "";
    for (let i = startOffset - 1; i >= 0; i--) {
      const d = daysInPrevMonth - i;
      html += `<button type="button" class="dp-day dp-day-outside" data-nav="prev" data-day="${d}">${d}</button>`;
    }
    for (let d = 1; d <= daysInMonth; d++) {
      const date = new Date(year, month, d);
      const classes = ["dp-day"];
      if (this._sameDay(date, this.today)) classes.push("dp-day-today");
      if (this.selectedDate && this._sameDay(date, this.selectedDate)) classes.push("dp-day-selected");
      if (this._isDisabled(date)) classes.push("dp-day-disabled");
      html += `<button type="button" class="${classes.join(" ")}" data-day="${d}">${d}</button>`;
    }
    const totalCells = startOffset + daysInMonth;
    const trailing = (7 - (totalCells % 7)) % 7;
    for (let d = 1; d <= trailing; d++) {
      html += `<button type="button" class="dp-day dp-day-outside" data-nav="next" data-day="${d}">${d}</button>`;
    }
    this.els.days.innerHTML = html;

    this.els.days.querySelectorAll(".dp-day").forEach(btn => {
      btn.addEventListener("click", () => {
        if (btn.classList.contains("dp-day-disabled")) return;
        const day = parseInt(btn.dataset.day, 10);
        const nav = btn.dataset.nav;
        const target = new Date(this.view);
        if (nav === "prev") target.setMonth(target.getMonth() - 1);
        else if (nav === "next") target.setMonth(target.getMonth() + 1);
        target.setDate(day);
        target.setHours(0, 0, 0, 0);
        this.view = new Date(target);
        this.selectedDate = target;
        this.renderDays();
        this._writeValue();
      });
    });
  };

  DateTimePicker.prototype.renderMonthGrid = function () {
    this.els.monthViewYear.textContent = this.view.getFullYear();
    let html = "";
    MONTHS_SHORT.forEach((m, i) => {
      const active = i === this.view.getMonth() ? "active" : "";
      html += `<button type="button" class="dp-month-cell ${active}" data-month="${i}">${m}</button>`;
    });
    this.els.monthGrid.innerHTML = html;
    this.els.monthGrid.querySelectorAll(".dp-month-cell").forEach(btn => {
      btn.addEventListener("click", () => {
        this.view.setMonth(parseInt(btn.dataset.month, 10));
        this._showView("day");
        this.renderDays();
      });
    });
  };

  DateTimePicker.prototype.renderYearGrid = function () {
    this.els.yearRangeLabel.textContent = `${this.yearRangeStart} - ${this.yearRangeStart + 11}`;
    let html = "";
    for (let y = this.yearRangeStart; y < this.yearRangeStart + 12; y++) {
      const active = y === this.view.getFullYear() ? "active" : "";
      html += `<button type="button" class="dp-year-cell ${active}" data-year="${y}">${y}</button>`;
    }
    this.els.yearGrid.innerHTML = html;
    this.els.yearGrid.querySelectorAll(".dp-year-cell").forEach(btn => {
      btn.addEventListener("click", () => {
        this.view.setFullYear(parseInt(btn.dataset.year, 10));
        this._showView("day");
        this.renderDays();
      });
    });
  };

  DateTimePicker.prototype._writeValue = function () {
    if (!this.selectedDate) return;
    this.input.value = `${toISODate(this.selectedDate)}T${pad(this.hour)}:${pad(this.minute)}`;
    this.input.dispatchEvent(new Event("input", { bubbles: true }));
    this.input.dispatchEvent(new Event("change", { bubbles: true }));
  };

  DateTimePicker.prototype._position = function () {
    const rect = this.input.getBoundingClientRect();
    const panelWidth = 520;
    let left = rect.left + window.scrollX;
    const maxLeft = window.scrollX + document.documentElement.clientWidth - panelWidth - 8;
    if (left > maxLeft) left = Math.max(8, maxLeft);
    this.panel.style.left = `${left}px`;
    this.panel.style.top = `${rect.bottom + window.scrollY + 8}px`;
  };

  DateTimePicker.prototype._bindInput = function () {
    this.input.addEventListener("mousedown", (e) => { e.preventDefault(); this.input.focus(); this.toggle(); });
    this.input.addEventListener("keydown", (e) => {
      if (["Enter", " ", "ArrowDown"].includes(e.key)) { e.preventDefault(); this.open(); }
      else if (e.key === "Escape") this.close();
      else e.preventDefault();
    });
    document.addEventListener("mousedown", (e) => {
      if (!this.panel.classList.contains("open")) return;
      if (e.target === this.input) return;
      if (!this.panel.contains(e.target)) this.close();
    });
    window.addEventListener("scroll", () => { if (this.panel.classList.contains("open")) this._position(); }, true);
    window.addEventListener("resize", () => { if (this.panel.classList.contains("open")) this._position(); });
  };

  DateTimePicker.prototype.toggle = function () { this.panel.classList.contains("open") ? this.close() : this.open(); };
  DateTimePicker.prototype.open = function () {
    const parsed = this._parseValue(this.input.value);
    if (parsed) {
      this.selectedDate = parsed.date;
      this.view = new Date(parsed.date);
      this.hour = parsed.hour;
      this.minute = parsed.minute;
    }
    this.wheel.setValue(this.hour, this.minute, true);
    this._updateDisplay();
    this._showView("day");
    this.renderDays();
    this._position();
    this.panel.classList.add("open");
  };
  DateTimePicker.prototype.close = function () { this.panel.classList.remove("open"); };

  function initPickers(root) {
    (root || document).querySelectorAll('input[type="date"].datepicker').forEach((input) => {
      if (input._datepickerInstance) return;
      input.readOnly = true;
      input._datepickerInstance = new DatePicker(input);
    });
    (root || document).querySelectorAll('input[type="time"].timepicker').forEach((input) => {
      if (input._timepickerInstance) return;
      input.readOnly = true;
      input._timepickerInstance = new TimePicker(input);
    });
    (root || document).querySelectorAll('input[type="datetime-local"].datetimepicker').forEach((input) => {
      if (input._datetimepickerInstance) return;
      input.readOnly = true;
      input._datetimepickerInstance = new DateTimePicker(input);
    });
  }

  document.addEventListener("DOMContentLoaded", () => initPickers());
  window.initPickers = initPickers;
})();
