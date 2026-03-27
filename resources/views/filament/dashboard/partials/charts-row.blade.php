       <div class="ornament">
          <div class="ornament-line"></div>
          <div class="ornament-dot"></div>
          <div class="ornament-diamond"></div>
          <div class="ornament-dot"></div>
          <div class="ornament-line rev"></div>
        </div>

        <!-- CHARTS ROW -->
        <div class="charts-row">

          <!-- Line chart: portfolio by years -->
          <div class="chart-card">
            <div class="chart-header">
              <div>
                <div class="chart-title">تطور المحفظة عبر السنوات</div>
                <div class="chart-sub">القيمة الإجمالية للمحفظة بالريال لكل سنة</div>
              </div>
              <div class="chart-badge">٢٠٢٠ - ٢٠٢٥</div>
            </div>
            <div style="margin-top:8px;">
              <svg viewBox="0 0 140 88">
                <!-- grid background -->
                <defs>
                  <pattern id="yearGrid" width="8" height="8" patternUnits="userSpaceOnUse">
                    <path d="M 8 0 L 0 0 0 8" fill="none" stroke="rgba(148,163,184,0.16)" stroke-width="0.4"/>
                  </pattern>
                </defs>
                <rect x="14" y="10" width="108" height="56" fill="url(#yearGrid)" />

                <!-- axes -->
                <line x1="18" y1="14" x2="18" y2="70" stroke="rgba(148,163,184,0.7)" stroke-width="1"/>
                <line x1="18" y1="70" x2="122" y2="70" stroke="rgba(148,163,184,0.7)" stroke-width="1"/>

                <!-- y ticks -->
                <g font-size="6" fill="#9ca3af">
                  <text x="14" y="68" text-anchor="end">0</text>
                  <text x="14" y="58" text-anchor="end">5</text>
                  <text x="14" y="48" text-anchor="end">10</text>
                  <text x="14" y="38" text-anchor="end">15</text>
                  <text x="14" y="28" text-anchor="end">20</text>
                </g>

                <!-- line: إجمالي المبلغ (ذهبي أساسي) -->
                <polyline
                  fill="none"
                  stroke="var(--gold-bright)"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  points="22,62 38,28 54,36 70,30 86,22 102,32"/>
                <!-- line: إجمالي المدفوعات (ذهبي متوسط) -->
                <polyline
                  fill="none"
                  stroke="var(--gold-mid)"
                  stroke-width="1.6"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  points="22,66 38,38 54,44 70,38 86,32 102,42"/>
                <!-- line: إجمالي الباقي (ذهبي داكن) -->
                <polyline
                  fill="none"
                  stroke="var(--gold-deep)"
                  stroke-width="1.4"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  points="22,68 38,56 54,58 70,48 86,40 102,52"/>

                <!-- نقاط البيانات -->
                <g fill="#050505">
                  <!-- الذهبي -->
                  <circle cx="22" cy="62" r="2" stroke="var(--gold-bright)" stroke-width="1"/>
                  <circle cx="38" cy="28" r="2" stroke="var(--gold-bright)" stroke-width="1"/>
                  <circle cx="54" cy="36" r="2" stroke="var(--gold-bright)" stroke-width="1"/>
                  <circle cx="70" cy="30" r="2" stroke="var(--gold-bright)" stroke-width="1"/>
                  <circle cx="86" cy="22" r="2" stroke="var(--gold-bright)" stroke-width="1"/>
                  <circle cx="102" cy="32" r="2" stroke="var(--gold-bright)" stroke-width="1"/>
                  <!-- المتوسط -->
                  <circle cx="22" cy="66" r="1.8" stroke="var(--gold-mid)" stroke-width="1"/>
                  <circle cx="38" cy="38" r="1.8" stroke="var(--gold-mid)" stroke-width="1"/>
                  <circle cx="54" cy="44" r="1.8" stroke="var(--gold-mid)" stroke-width="1"/>
                  <circle cx="70" cy="38" r="1.8" stroke="var(--gold-mid)" stroke-width="1"/>
                  <circle cx="86" cy="32" r="1.8" stroke="var(--gold-mid)" stroke-width="1"/>
                  <circle cx="102" cy="42" r="1.8" stroke="var(--gold-mid)" stroke-width="1"/>
                  <!-- الداكن -->
                  <circle cx="22" cy="68" r="1.6" stroke="var(--gold-deep)" stroke-width="1"/>
                  <circle cx="38" cy="56" r="1.6" stroke="var(--gold-deep)" stroke-width="1"/>
                  <circle cx="54" cy="58" r="1.6" stroke="var(--gold-deep)" stroke-width="1"/>
                  <circle cx="70" cy="48" r="1.6" stroke="var(--gold-deep)" stroke-width="1"/>
                  <circle cx="86" cy="40" r="1.6" stroke="var(--gold-deep)" stroke-width="1"/>
                  <circle cx="102" cy="52" r="1.6" stroke="var(--gold-deep)" stroke-width="1"/>
                </g>

                <!-- x labels -->
                <g font-size="7" fill="#9ca3af">
                  <text x="22" y="80" text-anchor="middle">٢٠٢٠</text>
                  <text x="38" y="80" text-anchor="middle">٢٠٢١</text>
                  <text x="54" y="80" text-anchor="middle">٢٠٢٢</text>
                  <text x="70" y="80" text-anchor="middle">٢٠٢٣</text>
                  <text x="86" y="80" text-anchor="middle">٢٠٢٤</text>
                  <text x="102" y="80" text-anchor="middle">٢٠٢٥</text>
                </g>

              </svg>
            </div>
            <div style="display:flex;justify-content:space-between;margin-top:4px;font-size:11px;color:#e5e7eb;">
              <span style="display:inline-flex;align-items:center;gap:6px;">
                <span style="width:20px;height:2px;background:var(--gold-deep);border-radius:999px;display:inline-block;"></span>
                الباقي
              </span>
              <span style="display:inline-flex;align-items:center;gap:6px;">
                <span style="width:20px;height:2px;background:var(--gold-mid);border-radius:999px;display:inline-block;"></span>
                المدفوعات
              </span>
              <span style="display:inline-flex;align-items:center;gap:6px;">
                <span style="width:20px;height:2px;background:var(--gold-bright);border-radius:999px;display:inline-block;"></span>
                المبلغ
              </span>
            </div>
          </div>

          <!-- Donut: share distribution -->
          <div class="chart-card">
            <div class="chart-header">
              <div>
                <div class="chart-title">توزيع المناطق العقارية</div>
                <div class="chart-sub">حسب المناطق الأكثر استثماراً في المحفظة</div>
              </div>
              <div class="chart-badge">٦ مناطق رئيسية</div>
            </div>
            <div class="donut-wrap">
              <svg class="donut-svg" width="110" height="110" viewBox="0 0 110 110">
                <circle cx="55" cy="55" r="40" fill="none" stroke="#1A1A1A" stroke-width="20"/>
                <!-- Segments: total = 251.3 -->
                <circle cx="55" cy="55" r="40" fill="none" stroke="#D4AF37" stroke-width="20"
                  stroke-dasharray="110.6 140.7" stroke-dashoffset="0"
                  transform="rotate(-90 55 55)"/>
                <circle cx="55" cy="55" r="40" fill="none" stroke="#C49A2A" stroke-width="20"
                  stroke-dasharray="75.4 175.9" stroke-dashoffset="-110.6"
                  transform="rotate(-90 55 55)"/>
                <circle cx="55" cy="55" r="40" fill="none" stroke="#8B6914" stroke-width="20"
                  stroke-dasharray="50.3 201" stroke-dashoffset="-186"
                  transform="rotate(-90 55 55)"/>
                <circle cx="55" cy="55" r="40" fill="none" stroke="#3D3D3D" stroke-width="20"
                  stroke-dasharray="15 236.3" stroke-dashoffset="-236.3"
                  transform="rotate(-90 55 55)"/>
                <text x="55" y="52" text-anchor="middle" font-family="Amiri" font-size="16" fill="#D4AF37" font-weight="700">6</text>
                <text x="55" y="65" text-anchor="middle" font-family="Tajawal" font-size="9" fill="#6B6560">مناطق</text>
              </svg>
              <div class="donut-legend">
                <div class="legend-item">
                  <div class="legend-dot" style="background:#D4AF37"></div>
                  الرياض
                  <span class="legend-pct">٣٥٪</span>
                </div>
                <div class="legend-item">
                  <div class="legend-dot" style="background:#C49A2A"></div>
                  جدة
                  <span class="legend-pct">٢٥٪</span>
                </div>
                <div class="legend-item">
                  <div class="legend-dot" style="background:#8B6914"></div>
                  الدمام
                  <span class="legend-pct">٢٠٪</span>
                </div>
                <div class="legend-item">
                  <div class="legend-dot" style="background:#3D3D3D"></div>
                  أبوظبي / دبي
                  <span class="legend-pct">٢٠٪</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Sparklines -->
          <div class="chart-card">
            <div class="chart-header">
              <div>
                <div class="chart-title">أبرز العقارات من حيث التكلفة</div>
                <div class="chart-sub">أعلى المباني من حيث قيمة الاستثمار</div>
              </div>
            </div>
            <div class="sparkline-grid">
              <div class="spark-item">
                <div class="spark-info">
                  <div class="spark-name">برج النخيل</div>
                  <div class="spark-val">٨.٤م ﷼</div>
                  <div class="spark-chg up">↑ ٨.٢٪</div>
                </div>
                <svg class="spark-svg" width="70" height="32" viewBox="0 0 70 32">
                  <polyline points="0,28 12,22 24,18 36,14 48,10 60,6 70,4" fill="none" stroke="#D4AF37" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <div class="spark-item">
                <div class="spark-info">
                  <div class="spark-name">مجمع الواحة</div>
                  <div class="spark-val">٦.١م ﷼</div>
                  <div class="spark-chg up">↑ ٥.١٪</div>
                </div>
                <svg class="spark-svg" width="70" height="32" viewBox="0 0 70 32">
                  <polyline points="0,26 12,22 24,24 36,18 48,14 60,12 70,8" fill="none" stroke="#C49A2A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <div class="spark-item">
                <div class="spark-info">
                  <div class="spark-name">أبراج المدينة</div>
                  <div class="spark-val">٥.٧م ﷼</div>
                  <div class="spark-chg down">↓ ١.٣٪</div>
                </div>
                <svg class="spark-svg" width="70" height="32" viewBox="0 0 70 32">
                  <polyline points="0,8 12,10 24,9 36,14 48,18 60,20 70,24" fill="none" stroke="#f87171" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <div class="spark-item">
                <div class="spark-info">
                  <div class="spark-name">برج الفيصلية</div>
                  <div class="spark-val">٤.٢م ﷼</div>
                  <div class="spark-chg up">↑ ١١.٦٪</div>
                </div>
                <svg class="spark-svg" width="70" height="32" viewBox="0 0 70 32">
                  <polyline points="0,30 12,26 24,20 36,16 48,10 60,6 70,2" fill="none" stroke="#4ade80" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
            </div>
          </div>

        </div>