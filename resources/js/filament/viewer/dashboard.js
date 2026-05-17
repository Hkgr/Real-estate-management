// TODO: Replace mock data with Laravel injected payload in phase 4.
(function () {
/* ─── DATA ─── */
const buildings = [
  {
    name: 'برج النخيل التجاري',
    city: 'الرياض',
    type: 'حي العليا',
    units: 48,
    floors: 18,
    year: 2018,
    area: 12400,
    share: 45,
    value: 8400000,
    rent: 24000,
    status: 'نشط',
    propId: 'PRO-001',
    ownDate: '2020-03-15',
    propNo: '١٠٢٤/أ',
    mahder: 'محضر رقم ٣٤٥/١٤٤٢',
    division: 'قطع تجارية على شارع رئيسي',
    geo: 'https://maps.google.com',
    details: 'برج تجاري حديث في قلب حي العليا التجاري، يحتوي على مكاتب فاخرة بمواصفات عالية وتشطيبات مميزة مع مواقف سيارات مخصصة.',
    opsCount: 3,
    opsDetails: [
      '01/01/2025 — توزيع أرباح ربع سنوي بقيمة ٢٥٠,٠٠٠ دولار.',
      '15/03/2025 — صيانة دورية للمصاعد والواجهات الزجاجية.',
      '30/06/2025 — تجديد عقد إيجار رئيسي لمدة ثلاث سنوات.'
    ],
    payments: '٣ دفعات مسددة من أصل ٤',

    // ── تفاصيل تجريبية لصفحة البطاقة الجديدة ──
    totalOpShares: 1250,
    shares: {
      abdulqader: '٢٧٥ سهم',
      riyad: '٣٢٠ سهم'
    },
    operations: [
      {
        type: 'شراء',
        prevOwners: ['شركة الواجهة التجارية'],
        newOwners: ['د. عبد القادر السنكري', 'رياض عسلي'],
        team1: ['أحمد عبدالله', 'سارة محمد'],
        team2: ['خالد حسن', 'ريم خالد'],
        amount: 150,
        unit: 'سهم',
        method: 'عقد تقرير عقاري',
        contractNo: 'CTR-1024-01',
        contractDate: '2024-11-12',
        notes: 'تمت العملية وفق إجراءات السجل العقاري وبحضور الشهود.',
        witness1: 'عبدالله سالم',
        witness2: 'ماجد يوسف'
      },
      {
        type: 'بيع',
        prevOwners: ['رياض عسلي'],
        newOwners: ['د. عبد القادر السنكري'],
        team1: ['فهد علي'],
        team2: ['نور أحمد'],
        amount: 45,
        unit: 'نسبة مئوية',
        method: 'عقد عادي',
        contractNo: 'CTR-1024-02',
        contractDate: '2025-05-03',
        notes: 'بيع حصة جزئية مع تحديث بيانات المالك.',
        witness1: 'سلمان ناصر',
        witness2: 'محمد عبدالعزيز'
      }
    ],
    signals: [
      {
        signalId: 'SIG-001',
        no: 'A-10021',
        date: '2025-03-11',
        type: 'دعوى',
        notes: 'تم تقديم الدعوى لدى المحكمة العقارية بخصوص برج النخيل التجاري — مطابق لسجل تقرير الإشارات.',
        owners: ['أحمد محمد العلي'],
        defendants: ['شركة التوريد']
      },
      {
        signalId: 'SIG-015',
        no: 'A-30150',
        date: '2025-01-20',
        type: 'حجز',
        notes: 'حجز تحفظي مؤقت لحين استكمال إجراء إداري؛ المعرّف SIG-015 مطابق لسجل تقرير الإشارات.',
        owners: ['د. عبد القادر السنكري'],
        defendants: ['جهة تمويل']
      }
    ],
    attachments: [
      { name: 'صك الملكية.pdf', issuedAt: '2024-11-12' },
      { name: 'عقد البيع.pdf', issuedAt: '2025-05-03' },
      { name: 'محضر استلام.pdf', issuedAt: '2025-01-01' }
    ],
    ownedValueUsd: '420,000 $',
    totalPaymentsUsd: '180,000 $',
    remainingUsd: '240,000 $',
    paymentsUsd: [
      { date: '2025-02-01', amountUsd: 60000 },
      { date: '2025-04-01', amountUsd: 60000 },
      { date: '2025-07-01', amountUsd: 60000 }
    ]
  },
  {
    name: 'مجمع الواحة السكني',
    city: 'جدة',
    type: 'حي الحمراء',
    units: 86,
    floors: 12,
    year: 2015,
    area: 28600,
    share: 32,
    value: 6100000,
    rent: 8500,
    status: 'نشط',
    propId: 'PRO-002',
    ownDate: '2019-07-22',
    propNo: '٢١١٩/ب',
    mahder: 'محضر رقم ٢١٧/١٤٤٠',
    division: 'مجمع سكني مغلق بعدة مبانٍ',
    geo: 'https://maps.google.com',
    details: 'مجمع سكني متكامل الخدمات بالقرب من الكورنيش، يضم شققاً عائلية بمساحات مختلفة وحدائق داخلية ومناطق ألعاب.',
    opsCount: 4,
    opsDetails: [
      '10/02/2025 — إضافة مواقف مظللة إضافية.',
      '05/04/2025 — تحسين إنارة الممرات الداخلية.',
      '20/05/2025 — توقيع عقود إيجار جديدة لـ ٦ شقق.',
      '01/07/2025 — مراجعة عقود الصيانة السنوية.'
    ],
    payments: '٤ دفعات مكتملة حتى تاريخه',
    signals: [
      {
        signalId: 'SIG-003',
        no: 'A-20660',
        date: '2025-04-21',
        type: 'تظلم',
        notes: 'تظلم مرتبط بعقد صيانة المجمع — مطابق لمعلومات تقرير الإشارات.',
        owners: ['مجموعة مستثمري الواحة'],
        defendants: ['شركة إدارة المجمع']
      }
    ]
  },
  {
    name: 'أبراج المدينة المكتبية',
    city: 'الرياض',
    type: 'حي النزهة',
    units: 36,
    floors: 22,
    year: 2019,
    area: 9200,
    share: 28,
    value: 5700000,
    rent: 32000,
    status: 'جزئي',
    propId: 'PRO-003',
    ownDate: '2021-01-10',
    propNo: '٣٠٥٨/ج',
    mahder: 'محضر رقم ٤٥٢/١٤٤١',
    division: 'برج مكاتب متعدد الاستخدام',
    geo: 'https://maps.google.com',
    details: 'برجان إداريان بمكاتب مطلة على الطرق الرئيسية، مجهزان ببنية تحتية تقنية حديثة ومواقف متعددة الأدوار.',
    opsCount: 2,
    opsDetails: [
      '12/01/2025 — توقيع عقد إيجار مع شركة تقنية عالمية.',
      '18/06/2025 — تحديث أنظمة الأمن والدخول الذكي.'
    ],
    payments: '٢ دفعة مسددة ودفعة واحدة متبقية',
    signals: [
      {
        signalId: 'SIG-002',
        no: 'A-10310',
        date: '2026-02-03',
        type: 'استيفاء',
        notes: 'استيفاء وتسوية مرتبطة بأبراج المدينة المكتبية — مطابق لسجل تقرير الإشارات.',
        owners: ['ريم خالد الشامي'],
        defendants: ['مقاول التنفيذ']
      }
    ]
  },
  {
    name: 'برج الفيصلية الفندقي',
    city: 'الدمام',
    type: 'حي الشاطئ',
    units: 22,
    floors: 8,
    year: 2020,
    area: 6800,
    share: 50,
    value: 4200000,
    rent: 45000,
    status: 'نشط',
    propId: 'PRO-004',
    ownDate: '2018-11-05',
    propNo: '٤١٠٧/د',
    mahder: 'محضر رقم ٥٦٠/١٤٤٢',
    division: 'برج فندقي مطل على البحر',
    geo: 'https://maps.google.com',
    details: 'برج فندقي يطل على الكورنيش مباشرة، يحتوي على أجنحة فندقية ومساحات استقبال فاخرة وقاعات مناسبات.',
    opsCount: 5,
    opsDetails: [
      '05/01/2025 — تجديد عقود مع شركة تشغيل فندقي.',
      '22/02/2025 — إطلاق باقة عروض منتصف الأسبوع.',
      '10/04/2025 — ترميم جزء من الواجهة البحرية.',
      '15/06/2025 — توقيع عقد فعاليات سنوية.',
      '01/08/2025 — تحديث الأثاث في الأجنحة التنفيذية.'
    ],
    payments: '٥ دفعات مسددة بالكامل',
    signals: [
      {
        signalId: 'SIG-004',
        no: 'A-21891',
        date: '2025-08-03',
        type: 'تنفيذ',
        notes: 'طلب تنفيذ بخصوص مستحقات تشغيل فندقي — مطابق لمعلومات تقرير الإشارات.',
        owners: ['شركة واجهات الخليج'],
        defendants: ['مشغل الفندق الحالي']
      }
    ]
  },
  {
    name: 'مركز الأعمال الدولي',
    city: 'أبوظبي',
    type: 'منطقة الكورنيش',
    units: 60,
    floors: 30,
    year: 2016,
    area: 18000,
    share: 20,
    value: 3900000,
    rent: 28000,
    status: 'قيد المراجعة',
    propId: 'PRO-005',
    ownDate: '2022-06-18',
    propNo: '٥٢٣٠/هـ',
    mahder: 'محضر رقم ٢٣٠/١٤٣٩',
    division: 'مركز أعمال على شارعين',
    geo: 'https://maps.google.com',
    details: 'مبنى مكاتب دولية في منطقة مالية نشطة، يضم شركات متعددة الجنسيات وبمساحات مكتبية مرنة.',
    opsCount: 1,
    opsDetails: [
      '25/03/2025 — مراجعة شاملة للعقود الحالية وخطط إعادة التأجير.'
    ],
    payments: 'دفعة واحدة مبدئية قيد التسوية',
    signals: [
      {
        signalId: 'SIG-005',
        no: 'A-22105',
        date: '2025-06-17',
        type: 'مراجعة',
        notes: 'مراجعة عقارية إدارية لمركز الأعمال الدولي — مطابق لمعلومات تقرير الإشارات.',
        owners: ['هيئة المحفظة — أبوظبي'],
        defendants: []
      }
    ]
  },
  {
    name: 'بوابة الرياض التجارية',
    city: 'الرياض',
    type: 'طريق الملك فهد',
    units: 40,
    floors: 14,
    year: 2021,
    area: 11200,
    share: 38,
    value: 7200000,
    rent: 22000,
    status: 'نشط',
    propId: 'PRO-006',
    ownDate: '2017-09-30',
    propNo: '٦١٨٩/و',
    mahder: 'محضر رقم ٣١٢/١٤٤٣',
    division: 'مركز تجاري ومكاتب',
    geo: 'https://maps.google.com',
    details: 'مبنى تجاري حديث على طريق الملك فهد، يضم معارض تجارية في الأدوار السفلية ومكاتب في الأدوار العليا.',
    opsCount: 3,
    opsDetails: [
      '02/02/2025 — افتتاح معرض جديد للعلامات الفاخرة.',
      '18/03/2025 — تحديث أنظمة التكييف المركزية.',
      '29/05/2025 — إعادة تقسيم بعض المساحات المكتبية.'
    ],
    payments: '٣ دفعات مجدولة خلال العام',
    signals: [
      {
        signalId: 'SIG-006',
        no: 'A-23144',
        date: '2025-09-09',
        type: 'دعوى',
        notes: 'نزاع على إيقاف أعمال تأجير جزئية — مطابق لمعلومات تقرير الإشارات.',
        owners: ['شركة بوابة الرياض القابضة'],
        defendants: ['مستأجر سابق — محل رقم ٤']
      }
    ]
  },
  {
    name: 'أبراج جدة الإدارية',
    city: 'جدة',
    type: 'حي الرويس',
    units: 55,
    floors: 25,
    year: 2017,
    area: 14500,
    share: 25,
    value: 5100000,
    rent: 26000,
    status: 'نشط',
    propId: 'PRO-007',
    ownDate: '2023-02-14',
    propNo: '٧٠٢٤/ز',
    mahder: 'محضر رقم ١١٠/١٤٤٠',
    division: 'أبراج مكتبية متجاورة',
    geo: 'https://maps.google.com',
    details: 'مجمع أبراج مكتبية بالقرب من المراكز الحيوية، مع ردهات استقبال واسعة وأنظمة أمن ومواقف تحت الأرض.',
    opsCount: 2,
    opsDetails: [
      '07/01/2025 — ترقية أنظمة المراقبة الأمنية.',
      '21/04/2025 — إعادة تصميم بهو الاستقبال الرئيسي.'
    ],
    payments: '٢ دفعة مسددة من أصل ٣',
    signals: [
      {
        signalId: 'SIG-007',
        no: 'A-24008',
        date: '2025-11-02',
        type: 'صلح',
        notes: 'مسار صلح قبل الدعوى — مطابق لمعلومات تقرير الإشارات.',
        owners: ['شركة مسارات جدة للعقارات'],
        defendants: ['مقاول واجهات زجاجية']
      }
    ]
  },
  {
    name: 'فيلات بيوت الشمال',
    city: 'الرياض',
    type: 'حي الياسمين',
    units: 18,
    floors: 3,
    year: 2022,
    area: 9000,
    share: 60,
    value: 6800000,
    rent: 12000,
    status: 'نشط',
    propId: 'PRO-008',
    ownDate: '2016-04-25',
    propNo: '٨١٥٠/ح',
    mahder: 'محضر رقم ١٧٥/١٤٤٤',
    division: 'مجمع فلل سكنية',
    geo: 'https://maps.google.com',
    details: 'مجموعة فلل سكنية حديثة التصميم بواجهات عصرية، مخصصة لسكن العائلات مع حدائق ومساحات خارجية خاصة.',
    opsCount: 3,
    opsDetails: [
      '11/02/2025 — تسليم فلل جديدة للمستأجرين.',
      '30/03/2025 — أعمال تنسيق حدائق إضافية.',
      '19/06/2025 — إضافة كاميرات مراقبة على المداخل.'
    ],
    payments: '٣ دفعات شهرية منتظمة',
    signals: [
      {
        signalId: 'SIG-008',
        no: 'A-25090',
        date: '2025-05-29',
        type: 'حجز',
        notes: 'حجز وفق تنبيه بنكي على جزء من المجمع — مطابق لمعلومات تقرير الإشارات.',
        owners: ['جمعية ملاك بيوت الشمال'],
        defendants: ['البنك الأهلي — إدارة التحصيل']
      }
    ]
  },
  {
    name: 'مجمع دبي للأعمال',
    city: 'دبي',
    type: 'منطقة الخليج التجاري',
    units: 72,
    floors: 35,
    year: 2014,
    area: 22000,
    share: 15,
    value: 3200000,
    rent: 35000,
    status: 'جزئي',
    propId: 'PRO-009',
    ownDate: '2024-08-01',
    propNo: '٩٠٠٢/ط',
    mahder: 'محضر رقم ٢٨٠/١٤٣٨',
    division: 'برج أعمال متعدد الاستخدام',
    geo: 'https://maps.google.com',
    details: 'برج أعمال في قلب منطقة الخليج التجاري، يضم مكاتب ومعارض وقاعات اجتماعات بإطلالات مفتوحة.',
    opsCount: 4,
    opsDetails: [
      '09/01/2025 — إعادة هيكلة عقود بعض المستأجرين.',
      '14/03/2025 — توسعة قاعة الاجتماعات الرئيسية.',
      '27/05/2025 — تحسين مساحات الخدمات المشتركة.',
      '08/07/2025 — إضافة لوحة إرشادية رقمية في البهو.'
    ],
    payments: '٤ دفعات ربع سنوية',
    signals: [
      {
        signalId: 'SIG-009',
        no: 'A-26011',
        date: '2025-10-14',
        type: 'إنذار',
        notes: 'إنذار بسبب تأخر أقساط الخدمات المشتركة — مطابق لمعلومات تقرير الإشارات.',
        owners: ['إدارة البرج — دبي'],
        defendants: ['شركة تأجير المساحات المشتركة']
      }
    ]
  },
  {
    name: 'برج المنارة السكني',
    city: 'الدمام',
    type: 'حي المنار',
    units: 64,
    floors: 16,
    year: 2019,
    area: 16800,
    share: 40,
    value: 4900000,
    rent: 9000,
    status: 'نشط',
    propId: 'PRO-010',
    ownDate: '2015-12-20',
    propNo: '١٠١٥٥/ي',
    mahder: 'محضر رقم ٣٢٠/١٤٤١',
    division: 'برج شقق سكنية',
    geo: 'https://maps.google.com',
    details: 'برج سكني متوسط الارتفاع بالقرب من الخدمات الأساسية، يضم شققاً متوسطة المساحة بمواقف مخصصة.',
    opsCount: 2,
    opsDetails: [
      '03/02/2025 — تركيب مصاعد جديدة عالية الكفاءة.',
      '25/05/2025 — إعادة طلاء الممرات والأدوار المشتركة.'
    ],
    payments: '٢ دفعة سنوية مستلمة',
    signals: [
      {
        signalId: 'SIG-010',
        no: 'A-27033',
        date: '2025-07-06',
        type: 'مخالفة',
        notes: 'مخالفة بلدية مؤقتة في مواقف الزوار — مطابق لمعلومات تقرير الإشارات.',
        owners: ['شركة المنارة الإسكانية'],
        defendants: ['بلدية المنطقة الشرقية']
      }
    ]
  },
  {
    name: 'مركز أبوظبي المالي',
    city: 'أبوظبي',
    type: 'المنطقة المالية',
    units: 45,
    floors: 28,
    year: 2013,
    area: 13500,
    share: 18,
    value: 2800000,
    rent: 30000,
    status: 'قيد المراجعة',
    propId: 'PRO-011',
    ownDate: '2020-05-07',
    propNo: '١١٢٠٠/ك',
    mahder: 'محضر رقم ١٥٠/١٤٣٧',
    division: 'مبنى مكاتب رئيسية',
    geo: 'https://maps.google.com',
    details: 'مبنى مكاتب لشركات مالية واستثمارية، مزود بقاعات اجتماعات تنفيذية وخدمات استقبال على مدار الساعة.',
    opsCount: 1,
    opsDetails: [
      '18/04/2025 — مراجعة عقود شركات الخدمات والدعم اللوجستي.'
    ],
    payments: 'دفعة مراجعة قيد الاعتماد',
    signals: [
      {
        signalId: 'SIG-011',
        no: 'A-28077',
        date: '2025-12-01',
        type: 'تدقيق',
        notes: 'تدقيق داخلي للعقود المالية بالمركز — مطابق لمعلومات تقرير الإشارات.',
        owners: ['مكتب الالتزام — أبوظبي'],
        defendants: []
      }
    ]
  },
  {
    name: 'الحي الذهبي السكني',
    city: 'جدة',
    type: 'حي الشاطئ الذهبي',
    units: 32,
    floors: 8,
    year: 2023,
    area: 8400,
    share: 55,
    value: 5600000,
    rent: 11000,
    status: 'نشط',
    propId: 'PRO-012',
    ownDate: '2019-03-17',
    propNo: '١٢٠٥٥/ل',
    mahder: 'محضر رقم ٤٢٥/١٤٤٤',
    division: 'مجمع شقق فاخرة',
    geo: 'https://maps.google.com',
    details: 'مجمع سكني فاخر بإطلالة بحرية، يضم شققاً ذات تشطيبات عالية المستوى ومرافق ترفيهية للسكان.',
    opsCount: 3,
    opsDetails: [
      '06/01/2025 — إطلاق خدمة الاستقبال على مدار الساعة.',
      '17/03/2025 — إضافة نادي صحي ومسبح داخلي.',
      '12/06/2025 — حملات تسويق للوحدات الفارغة.'
    ],
    payments: '٣ دفعات فندقية قيد التحصيل',
    signals: [
      {
        signalId: 'SIG-012',
        no: 'A-29120',
        date: '2025-03-08',
        type: 'دعوى',
        notes: 'دعوى بسبب تأخر تسليم وحدات مؤجَّرة سياحياً — مطابق لمعلومات تقرير الإشارات.',
        owners: ['شركة الواجهات الذهبية'],
        defendants: ['شركة تأجير وإدارة وحدات']
      }
    ]
  },
  {
    name: 'مجمع الروضة الفندقي',
    city: 'الرياض',
    type: 'حي الروضة',
    units: 120,
    floors: 20,
    year: 2018,
    area: 32000,
    share: 22,
    value: 9100000,
    rent: 40000,
    status: 'نشط',
    propId: 'PRO-013',
    ownDate: '2021-09-29',
    propNo: '١٣٥٦٠/م',
    mahder: 'محضر رقم ٣٣٠/١٤٤٠',
    division: 'مجمع فندقي وشقق مخدومة',
    geo: 'https://maps.google.com',
    details: 'مجمع فندقي يحتوي على غرف فندقية وشقق مخدومة طويلة الأمد مع خدمات استقبال ونظافة.',
    opsCount: 4,
    opsDetails: [
      '04/02/2025 — تحديث نظام الحجز الإلكتروني.',
      '22/03/2025 — عقد صيانة شامل للأدوار العليا.',
      '09/05/2025 — إضافة خدمة نقل من وإلى المطار.',
      '28/07/2025 — ترقية أثاث بعض الشقق المخدومة.'
    ],
    payments: '٤ دفعات شهرية من شركات التعاقد',
    signals: [
      {
        signalId: 'SIG-013',
        no: 'A-30005',
        date: '2025-06-26',
        type: 'استيفاء جزئي',
        notes: 'سداد جزئي لرسوم الطاقة — مطابق لمعلومات تقرير الإشارات.',
        owners: ['شركة تشغيل الروضة الفندقي'],
        defendants: ['شركة المرافق الموحَّدة']
      }
    ]
  },
  {
    name: 'برج الخليج للأعمال',
    city: 'دبي',
    type: 'واجهة الخليج',
    units: 90,
    floors: 42,
    year: 2015,
    area: 26000,
    share: 12,
    value: 4500000,
    rent: 38000,
    status: 'جزئي',
    propId: 'PRO-014',
    ownDate: '2018-06-11',
    propNo: '١٤٢٢٠/ن',
    mahder: 'محضر رقم ٢٧٠/١٤٣٩',
    division: 'برج مكاتب على الواجهة البحرية',
    geo: 'https://maps.google.com',
    details: 'برج أعمال على الواجهة البحرية مع إطلالات بانورامية، يضم مكاتب للشركات العالمية ومرافق مشتركة راقية.',
    opsCount: 2,
    opsDetails: [
      '13/03/2025 — إعادة تأجير طابق كامل لشركة دولية.',
      '30/06/2025 — أعمال صيانة للمرسى القريب من البرج.'
    ],
    payments: '٢ دفعة نصف سنوية',
    signals: [
      {
        signalId: 'SIG-014',
        no: 'A-31088',
        date: '2025-11-19',
        type: 'تحكيم',
        notes: 'اتفاق تحكيم لحسم نسب الإيرادات — مطابق لمعلومات تقرير الإشارات.',
        owners: ['شركة أبراج الخليج دبي'],
        defendants: ['شريك تشغيل دولي — فرع المنطقة']
      }
    ]
  },
];

/** أصحاب الحصص لكل عقار (معرّف مالك من تقرير المالك + نسبة تقريبية) */
const buildingOwnerStakes = {
  'PRO-001': [{ ownerId: 'OWN-003', share: '42%' }, { ownerId: 'OWN-017', share: '33%' }, { ownerId: 'OWN-001', share: '25%' }],
  'PRO-002': [{ ownerId: 'OWN-004', share: '100%' }],
  'PRO-003': [{ ownerId: 'OWN-002', share: '72%' }, { ownerId: 'OWN-018', share: '28%' }],
  'PRO-004': [{ ownerId: 'OWN-005', share: '100%' }],
  'PRO-005': [{ ownerId: 'OWN-006', share: '100%' }],
  'PRO-006': [{ ownerId: 'OWN-007', share: '100%' }],
  'PRO-007': [{ ownerId: 'OWN-008', share: '100%' }],
  'PRO-008': [{ ownerId: 'OWN-009', share: '100%' }],
  'PRO-009': [{ ownerId: 'OWN-010', share: '100%' }],
  'PRO-010': [{ ownerId: 'OWN-011', share: '100%' }],
  'PRO-011': [{ ownerId: 'OWN-012', share: '100%' }],
  'PRO-012': [{ ownerId: 'OWN-013', share: '100%' }],
  'PRO-013': [{ ownerId: 'OWN-014', share: '58%' }, { ownerId: 'OWN-019', share: '42%' }],
  'PRO-014': [{ ownerId: 'OWN-015', share: '100%' }]
};

const totalAreaAll = buildings.reduce((sum, b) => sum + (b.area || 0), 0);
let filteredData = [...buildings];
/** صفوف تفصيل العقارات (خرطة، ملاحظات، دفعات…) */
let propertyExpandedKeys = new Set();
let rowsLimit = 'all'; // rows per page ('all' = no limit)
let currentPage = 1;
let selectedProps = new Set();
let multiSelectEnabled = false;
let selectedCountriesFilter = new Set();
let selectedCitiesFilter = new Set();
let selectedTypesFilter = new Set();
let selectedSubTypesFilter = new Set();
let selectedAreasFilter = new Set();
let propCreatedFrom = '';
let propCreatedTo = '';
let propOwnFrom = '';
let propOwnTo = '';
let propEnteredBy = '';
let propUpdatedFrom = '';
let propUpdatedTo = '';
let selectedOpStatusFilter = new Set();
let selectedPaymentFinanceFilter = new Set();
const countryGovernorates = {
  'سورية': ['دمشق', 'حلب', 'حمص', 'اللاذقية', 'حماة', 'طرطوس', 'السويداء', 'دير الزور'],
  'الامارات': ['أبوظبي', 'دبي', 'الشارقة', 'عجمان', 'رأس الخيمة', 'الفجيرة', 'أم القيوين'],
  'أخرى': []
};
// فلتر العقار — 3 main categories
const propertyKinds = ['أرض', 'سكن', 'تجاري'];
// فلتر نوع العقار — sub-types per category
const propertySubTypes = {
  'أرض':   ['زراعية', 'سكنية'],
  'سكن':   ['منزل', 'فيلا'],
  'تجاري': ['مجمع', 'دكان', 'مول', 'مطعم', 'أخرى']
};
// Per-building type assignments
const buildingTypeData = {
  'PRO-001': { category: 'تجاري',  subType: 'مجمع'  },
  'PRO-002': { category: 'سكن',    subType: 'فيلا'  },
  'PRO-003': { category: 'تجاري',  subType: 'مول'   },
  'PRO-004': { category: 'تجاري',  subType: 'أخرى'  },
  'PRO-005': { category: 'تجاري',  subType: 'مجمع'  },
  'PRO-006': { category: 'تجاري',  subType: 'دكان'  },
  'PRO-007': { category: 'تجاري',  subType: 'مجمع'  },
  'PRO-008': { category: 'سكن',    subType: 'فيلا'  },
  'PRO-009': { category: 'تجاري',  subType: 'مجمع'  },
  'PRO-010': { category: 'سكن',    subType: 'منزل'  },
  'PRO-011': { category: 'تجاري',  subType: 'مول'   },
  'PRO-012': { category: 'سكن',    subType: 'منزل'  },
  'PRO-013': { category: 'تجاري',  subType: 'مطعم'  },
  'PRO-014': { category: 'أرض',    subType: 'سكنية' }
};
const defaultResponsiblePeople = [
  'أحمد العلي',
  'محمود الخطيب',
  'سارة الحسن',
  'ليث درويش',
  'ريم الشامي',
  'نور المصري'
];
const defaultEnteredBy = ['سارة', 'نور', 'أحمد', 'خالد', 'ريم', 'ليث'];
function getEnteredByOfBuilding(b, idx) {
  if (b.enteredBy) return b.enteredBy;
  return defaultEnteredBy[idx % defaultEnteredBy.length];
}

function inferCountryFromCity(city) {
  if (countryGovernorates['سورية'].includes(city)) return 'سورية';
  if (countryGovernorates['الامارات'].includes(city)) return 'الامارات';
  return 'أخرى';
}

function getCountryOfBuilding(b) {
  return b.country || inferCountryFromCity(b.city);
}

function getPropertyKindOfBuilding(b, idx) {
  if (b.propertyCategory) return b.propertyCategory;
  const td = buildingTypeData[b.propId];
  if (td) return td.category;
  return propertyKinds[idx % propertyKinds.length];
}

function getPropertySubTypeOfBuilding(b, idx) {
  if (b.propertySubType) return b.propertySubType;
  const td = buildingTypeData[b.propId];
  if (td) return td.subType;
  return '';
}

function getRegistrationDateOfBuilding(b, idx) {
  if (b.registeredAt) return b.registeredAt;
  const year = 2021 + (idx % 5);
  const month = ((idx % 12) + 1).toString().padStart(2, '0');
  const day = ((idx % 28) + 1).toString().padStart(2, '0');
  return `${year}-${month}-${day}`;
}

function getResponsiblePersonOfBuilding(b, idx) {
  if (b.responsiblePerson) return b.responsiblePerson;
  return defaultResponsiblePeople[idx % defaultResponsiblePeople.length];
}

function fmt(n) {
  return n.toLocaleString('ar-SA');
}

function formatShareOutOf2400(rawShare) {
  if (rawShare == null) return '—';
  const westernDigits = String(rawShare)
    .replace(/[٠-٩]/g, d => '٠١٢٣٤٥٦٧٨٩'.indexOf(d))
    .replace(/[۰-۹]/g, d => '۰۱۲۳۴۵۶۷۸۹'.indexOf(d));
  const match = westernDigits.match(/\d+(?:\.\d+)?/);
  if (!match) return '—';
  const parsed = Number(match[0]);
  if (!isFinite(parsed)) return '—';
  return `${Math.trunc(parsed)}/2400 سهم`;
}

/** عرض حصة العقار للجدول: النسبة % تُحسب من أصل 2400 سهمًا */
function formatStakeForDisplay(rawShare) {
  if (rawShare == null || rawShare === '') return '—';
  const str = String(rawShare).trim();
  const western = str
    .replace(/[٠-٩]/g, d => '٠١٢٣٤٥٦٧٨٩'.indexOf(d))
    .replace(/[۰-۹]/g, d => '۰۱۲۳۴۵۶۷۸۹'.indexOf(d));
  if (/%/.test(western) || /٪/.test(str)) {
    const m = western.match(/(\d+(?:\.\d+)?)/);
    if (!m) return '—';
    const pct = Number(m[1]);
    if (!isFinite(pct) || pct < 0) return '—';
    const shares = Math.round((pct / 100) * 2400);
    return `${Math.min(2400, Math.max(0, shares))}/2400 سهم`;
  }
  const slash = western.match(/^(\d+)\s*\/\s*2400/);
  if (slash) {
    const n = Math.min(2400, Math.max(0, parseInt(slash[1], 10)));
    return `${n}/2400 سهم`;
  }
  const plain = western.match(/^\s*(\d+)\s*$/);
  if (plain) {
    const v = parseInt(plain[1], 10);
    if (v >= 0 && v <= 2400) return `${v}/2400 سهم`;
  }
  return formatShareOutOf2400(rawShare);
}

const PREF_KEY = 'realestate_prefs';
const DEFAULT_USD_RATES = {
  LBP: 124,
  AED: 3.67
};
const CURRENCY_LABELS = {
  USD: 'USD',
  LBP: 'ليرة سورية',
  AED: 'درهم إماراتي'
};

function getPrefs() {
  try {
    return JSON.parse(localStorage.getItem(PREF_KEY)) || {};
  } catch {
    return {};
  }
}

function savePrefs(p) {
  localStorage.setItem(PREF_KEY, JSON.stringify(p));
}

function getExchangeRateFor(currency) {
  if (currency === 'USD') return 1;
  const p = getPrefs();
  const rates = p.exchangeRates || {};
  const customRate = Number(rates[currency]);
  if (isFinite(customRate) && customRate > 0) return customRate;
  return DEFAULT_USD_RATES[currency] || 1;
}

function updateCurrencyRateUi(currency) {
  const activeCurrency = currency || getPrefs().currency || 'USD';
  const rd = document.getElementById('rate-display');
  const rc = document.getElementById('rate-currency-name');
  const ri = document.getElementById('rate-input');
  const rate = getExchangeRateFor(activeCurrency);
  if (rd) {
    rd.textContent = rate.toLocaleString('ar-SA', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }
  if (rc) rc.textContent = CURRENCY_LABELS[activeCurrency] || activeCurrency;
  if (ri) {
    ri.value = String(rate);
    ri.disabled = activeCurrency === 'USD';
    ri.title = activeCurrency === 'USD' ? 'الدولار هو العملة الأساسية' : '';
  }
}

function formatAreaFromM2(m2) {
  if (typeof m2 !== 'number' || !isFinite(m2)) return '—';
  const p = getPrefs();
  if (p.area === 'ft2') {
    return fmt(Math.round(m2 * 10.76391041671)) + ' قدم²';
  }
  return fmt(m2) + ' م²';
}

function formatUsdMoney(usd) {
  if (usd == null || !isFinite(usd)) return '—';
  const p = getPrefs();
  const selected = p.currency || 'USD';
  if (selected === 'USD') {
    return usd.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '\u202F$';
  }
  const converted = usd * getExchangeRateFor(selected);
  return converted.toLocaleString('ar-SA', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' ' + (CURRENCY_LABELS[selected] || selected);
}

function parseUsdAmount(value) {
  if (typeof value === 'number' && isFinite(value)) return value;
  if (typeof value !== 'string') return 0;
  const normalized = value.replace(/,/g, '').replace(/[^\d.]/g, '');
  const num = Number(normalized);
  return isFinite(num) ? num : 0;
}

function shiftDateDays(isoDate, delta) {
  if (!isoDate || typeof isoDate !== 'string') return '';
  const t = Date.parse(isoDate);
  if (!isFinite(t)) return isoDate;
  const d = new Date(t + delta * 86400000);
  return d.toISOString().slice(0, 10);
}

function togglePropertyExpand(propNo, section) {
  const id = String(propNo) + '\x1e' + section;
  if (propertyExpandedKeys.has(id)) propertyExpandedKeys.delete(id);
  else propertyExpandedKeys.add(id);
  renderTable();
}

function isPropertyExpandOpen(propNo, section) {
  return propertyExpandedKeys.has(String(propNo) + '\x1e' + section);
}

function getVisiblePropertyColCount() {
  let n = 1;
  columnOrder.forEach(cls => {
    const key = cls.replace('col-', '');
    if (colVisible[key]) n++;
  });
  return n;
}

function operationalStatusBadge(s) {
  const map = {
    'يعمل': 'status-active',
    'جاري صيانته': 'status-partial',
    'متوقف عن العمل': 'status-pending'
  };
  const dot = { 'يعمل': '●', 'جاري صيانته': '◑', 'متوقف عن العمل': '○' };
  const v = String(s || '—');
  return `<span class="status-badge ${map[v] || 'status-pending'}">${dot[v] || '○'} ${v}</span>`;
}

function hydrateBuildingPortalFields() {
  const SAR_TO_USD = 3.75; // b.value is stored in SAR
  buildings.forEach((b, idx) => {
    const totalValSar = typeof b.value === 'number' && isFinite(b.value) ? b.value : 0;
    // Derive USD price via correct SAR→USD rate if not already in the data
    if (b.approxPriceUsd == null) b.approxPriceUsd = Math.round(totalValSar / SAR_TO_USD);
    if (b.actualPriceUsd  == null) b.actualPriceUsd  = Math.round(totalValSar / SAR_TO_USD);
    // Use the USD price as the single source of truth for all payment maths
    const totalValUsd = Number(b.approxPriceUsd) || Number(b.actualPriceUsd) || 0;
    // paid is already in USD (paymentsUsd)
    const paid = Array.isArray(b.paymentsUsd) && b.paymentsUsd.length
      ? b.paymentsUsd.reduce((sum, p) => sum + (Number(p.amountUsd) || 0), 0)
      : parseUsdAmount(b.totalPaymentsUsd);
    if (!b.createdAt) b.createdAt = getRegistrationDateOfBuilding(b, idx);
    if (!b.updatedAt) b.updatedAt = shiftDateDays(b.createdAt, 10 + (idx % 21));
    if (!b.enteredBy) b.enteredBy = getEnteredByOfBuilding(b, idx);
    if (!b.operationalStatus) {
      if (b.status === 'نشط') b.operationalStatus = 'يعمل';
      else if (b.status === 'جزئي') b.operationalStatus = 'جاري صيانته';
      else b.operationalStatus = 'متوقف عن العمل';
    }
    // paymentFinanceStatus: compare paid (USD) vs totalValUsd (USD) — same unit
    if (!b.paymentFinanceStatus) {
      b.paymentFinanceStatus = (totalValUsd > 0 && paid >= totalValUsd * 0.97)
        ? 'مدفوع بشكل كامل' : 'جزئي';
    }
    // Remainder in USD — can never exceed total
    const remUsd = Math.max(0, totalValUsd - paid);
    if (b.paymentRemainderUsd == null) b.paymentRemainderUsd = remUsd;
    if (!b.paymentRemainderLabel) {
      b.paymentRemainderLabel = remUsd <= 1
        ? 'لا يوجد'
        : `${Math.round(remUsd).toLocaleString('en-US')}\u202F$`;
    }
    if (!b.paymentDetailBlurb) {
      const lastPay = Array.isArray(b.paymentsUsd) && b.paymentsUsd.length
        ? b.paymentsUsd[b.paymentsUsd.length - 1].date : '';
      if (b.paymentFinanceStatus === 'مدفوع بشكل كامل') {
        b.paymentDetailBlurb = lastPay
          ? `اكتملت الدفعات بتاريخ ${lastPay}`
          : 'اكتملت الدفعات وفق الجدول';
      } else if (Array.isArray(b.paymentsUsd) && b.paymentsUsd.length >= 2) {
        const a = Number(b.paymentsUsd[0].amountUsd) || 0;
        const c = Number(b.paymentsUsd[1].amountUsd) || 0;
        b.paymentDetailBlurb = `دفعتين: ${Math.round(a).toLocaleString('en-US')}\u202F$ (${b.paymentsUsd[0].date}) و${Math.round(c).toLocaleString('en-US')}\u202F$ (${b.paymentsUsd[1].date})`;
      } else {
        b.paymentDetailBlurb = String(b.payments || 'دفعات جزئية — راجع تقرير المالية');
      }
    }
    const stakes = buildingOwnerStakes[b.propId];
    if (stakes && stakes.length && !b.propertyOwners) b.propertyOwners = stakes.slice();
  });
}

function renderFinancialOverviewStats() {
  const totalEl = document.getElementById('stat-total-value');
  const paidEl = document.getElementById('stat-paid-value');
  const remainingEl = document.getElementById('stat-remaining-value');
  if (!totalEl || !paidEl || !remainingEl) return;

  const usdRate = 3.75; // قيمة البيانات المخزنة في value
  const totalPortfolioUsd = buildings.reduce((sum, b) => {
    const usd = typeof b.value === 'number' && isFinite(b.value) ? (b.value / usdRate) : 0;
    return sum + usd;
  }, 0);

  const totalPaymentsUsd = buildings.reduce((sum, b) => {
    if (Array.isArray(b.paymentsUsd) && b.paymentsUsd.length) {
      return sum + b.paymentsUsd.reduce((inner, pay) => inner + (Number(pay.amountUsd) || 0), 0);
    }
    return sum + parseUsdAmount(b.totalPaymentsUsd);
  }, 0);

  const remainingUsd = Math.max(0, totalPortfolioUsd - totalPaymentsUsd);
  totalEl.textContent = formatUsdMoney(totalPortfolioUsd);
  paidEl.textContent = formatUsdMoney(totalPaymentsUsd);
  remainingEl.textContent = formatUsdMoney(remainingUsd);
  renderFinancialRemainingChart();
  renderFinancialGeoCostChart();
}

function renderFinancialRemainingChart() {
  const chartRoot = document.getElementById('financial-remaining-chart');
  if (!chartRoot) return;

  const usdRate = 3.75;
  const topRows = buildings
    .map((b, idx) => {
      const totalUsd = typeof b.value === 'number' && isFinite(b.value) ? (b.value / usdRate) : 0;
      const paidUsd = Array.isArray(b.paymentsUsd) && b.paymentsUsd.length
        ? b.paymentsUsd.reduce((sum, pay) => sum + (Number(pay.amountUsd) || 0), 0)
        : parseUsdAmount(b.totalPaymentsUsd);
      const remainingUsd = Math.max(0, totalUsd - paidUsd);
      return {
        idx,
        label: b.propNo || `عقار ${idx + 1}`,
        remainingUsd
      };
    })
    .sort((a, b) => b.remainingUsd - a.remainingUsd)
    .slice(0, 6);

  const maxRemaining = topRows.reduce((max, row) => Math.max(max, row.remainingUsd), 0);
  chartRoot.innerHTML = '';

  if (!topRows.length || maxRemaining <= 0) {
    chartRoot.innerHTML = '<div class="chart-sub">لا توجد بيانات كافية لعرض المخطط.</div>';
    return;
  }

  topRows.forEach((row) => {
    const wrap = document.createElement('div');
    wrap.className = 'bar-wrap';

    const bar = document.createElement('div');
    bar.className = 'bar';
    bar.style.height = `${Math.max(12, (row.remainingUsd / maxRemaining) * 100)}%`;
    bar.style.background = 'linear-gradient(180deg, var(--gold-bright), var(--gold-deep))';
    bar.title = `${row.label}: ${formatUsdMoney(row.remainingUsd)}`;

    const value = document.createElement('div');
    value.className = 'bar-val';
    value.textContent = formatUsdMoney(row.remainingUsd);

    const label = document.createElement('div');
    label.className = 'bar-label';
    label.textContent = row.label;

    wrap.appendChild(bar);
    wrap.appendChild(value);
    wrap.appendChild(label);
    chartRoot.appendChild(wrap);
  });
}

function renderFinancialGeoCostChart() {
  const root = document.getElementById('financial-geo-cost-chart');
  if (!root) return;
  const usdRate = 3.75;
  const byCity = {};
  buildings.forEach((b) => {
    const city = b.city || 'غير محدد';
    const usd = typeof b.value === 'number' && isFinite(b.value) ? (b.value / usdRate) : 0;
    byCity[city] = (byCity[city] || 0) + usd;
  });
  const rows = Object.entries(byCity)
    .map(([label, value]) => ({ label, value }))
    .sort((a, b) => b.value - a.value)
    .slice(0, 6);

  renderSimpleBars(root, rows, [
    'linear-gradient(180deg, var(--gold-bright), var(--gold-deep))',
    'linear-gradient(180deg, #60a5fa, #2563eb)',
    'linear-gradient(180deg, #34d399, #059669)',
    'linear-gradient(180deg, #f59e0b, #b45309)'
  ]);
}

function renderSimpleBars(rootEl, rows, palette) {
  if (!rootEl) return;
  const safeRows = Array.isArray(rows) ? rows : [];
  const maxValue = safeRows.reduce((max, row) => Math.max(max, Number(row.value) || 0), 0);
  rootEl.innerHTML = '';

  if (!safeRows.length || maxValue <= 0) {
    rootEl.innerHTML = '<div class="chart-sub">لا توجد بيانات كافية لعرض المخطط.</div>';
    return;
  }

  safeRows.forEach((row, idx) => {
    const wrap = document.createElement('div');
    wrap.className = 'bar-wrap';

    const bar = document.createElement('div');
    bar.className = 'bar';
    bar.style.height = `${Math.max(12, ((Number(row.value) || 0) / maxValue) * 100)}%`;
    bar.style.background = palette[idx % palette.length];
    bar.title = `${row.label}: ${Number(row.value || 0).toLocaleString('ar-SA')}`;

    const value = document.createElement('div');
    value.className = 'bar-val';
    value.textContent = Number(row.value || 0).toLocaleString('ar-SA');

    const label = document.createElement('div');
    label.className = 'bar-label';
    label.textContent = row.label;

    wrap.appendChild(bar);
    wrap.appendChild(value);
    wrap.appendChild(label);
    rootEl.appendChild(wrap);
  });
}

function renderLegalDonut(svgEl, legendEl, rows) {
  if (!svgEl || !legendEl) return;
  const safeRows = Array.isArray(rows) ? rows : [];
  const total = safeRows.reduce((s, r) => s + (Number(r.value) || 0), 0);
  svgEl.innerHTML = '';
  legendEl.innerHTML = '';

  if (!safeRows.length || total <= 0) {
    svgEl.innerHTML = '<text x="160" y="100" fill="#9ca3af" text-anchor="middle" font-size="12">لا توجد بيانات كافية</text>';
    return;
  }

  const colors = ['#D4AF37', '#C49A2A', '#8B6914', '#60a5fa', '#34d399', '#f87171'];
  const cx = 90;
  const cy = 100;
  const r = 58;
  const c = 2 * Math.PI * r;
  let offset = 0;

  const base = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
  base.setAttribute('cx', String(cx));
  base.setAttribute('cy', String(cy));
  base.setAttribute('r', String(r));
  base.setAttribute('fill', 'none');
  base.setAttribute('stroke', 'rgba(148,163,184,.25)');
  base.setAttribute('stroke-width', '18');
  svgEl.appendChild(base);

  safeRows.forEach((row, idx) => {
    const value = Number(row.value) || 0;
    const length = (value / total) * c;
    const seg = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    seg.setAttribute('cx', String(cx));
    seg.setAttribute('cy', String(cy));
    seg.setAttribute('r', String(r));
    seg.setAttribute('fill', 'none');
    seg.setAttribute('stroke', colors[idx % colors.length]);
    seg.setAttribute('stroke-width', '18');
    seg.setAttribute('stroke-linecap', 'round');
    seg.setAttribute('stroke-dasharray', `${Math.max(0, length - 1)} ${c}`);
    seg.setAttribute('stroke-dashoffset', String(-offset));
    seg.setAttribute('transform', `rotate(-90 ${cx} ${cy})`);
    svgEl.appendChild(seg);
    offset += length;

    const legendItem = document.createElement('span');
    legendItem.className = 'legal-legend-item';
    legendItem.innerHTML = `<span class="legal-legend-swatch" style="background:${colors[idx % colors.length]}"></span>${row.label} (${Math.round((value / total) * 100)}٪)`;
    legendEl.appendChild(legendItem);
  });

  const centerMain = document.createElementNS('http://www.w3.org/2000/svg', 'text');
  centerMain.setAttribute('x', String(cx));
  centerMain.setAttribute('y', '95');
  centerMain.setAttribute('text-anchor', 'middle');
  centerMain.setAttribute('fill', '#D4AF37');
  centerMain.setAttribute('font-size', '22');
  centerMain.setAttribute('font-weight', '700');
  centerMain.textContent = total.toLocaleString('ar-SA');
  svgEl.appendChild(centerMain);

  const centerSub = document.createElementNS('http://www.w3.org/2000/svg', 'text');
  centerSub.setAttribute('x', String(cx));
  centerSub.setAttribute('y', '112');
  centerSub.setAttribute('text-anchor', 'middle');
  centerSub.setAttribute('fill', '#9ca3af');
  centerSub.setAttribute('font-size', '11');
  centerSub.textContent = 'إجمالي الإشارات';
  svgEl.appendChild(centerSub);
}

function renderLegalTrend(svgEl, rows) {
  if (!svgEl) return;
  const safeRows = Array.isArray(rows) ? rows : [];
  svgEl.innerHTML = '';
  if (!safeRows.length) {
    svgEl.innerHTML = '<text x="160" y="100" fill="#9ca3af" text-anchor="middle" font-size="12">لا توجد بيانات كافية</text>';
    return;
  }

  const w = 320;
  const h = 200;
  const padX = 26;
  const padY = 24;
  const innerW = w - padX * 2;
  const innerH = h - padY * 2;
  const maxValue = Math.max(1, ...safeRows.map(r => Number(r.value) || 0));
  const points = safeRows.map((row, i) => {
    const x = padX + (i * innerW) / Math.max(1, safeRows.length - 1);
    const y = padY + innerH - ((Number(row.value) || 0) / maxValue) * innerH;
    return { x, y, label: row.label, value: Number(row.value) || 0 };
  });

  const grid = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
  grid.setAttribute('x', String(padX));
  grid.setAttribute('y', String(padY));
  grid.setAttribute('width', String(innerW));
  grid.setAttribute('height', String(innerH));
  grid.setAttribute('fill', 'rgba(148,163,184,.05)');
  grid.setAttribute('stroke', 'rgba(148,163,184,.25)');
  grid.setAttribute('stroke-dasharray', '4 4');
  svgEl.appendChild(grid);

  const poly = document.createElementNS('http://www.w3.org/2000/svg', 'polyline');
  poly.setAttribute('fill', 'none');
  poly.setAttribute('stroke', '#D4AF37');
  poly.setAttribute('stroke-width', '2.5');
  poly.setAttribute('stroke-linejoin', 'round');
  poly.setAttribute('stroke-linecap', 'round');
  poly.setAttribute('points', points.map(p => `${p.x},${p.y}`).join(' '));
  svgEl.appendChild(poly);

  const avg = safeRows.reduce((s, r) => s + (Number(r.value) || 0), 0) / safeRows.length;
  const avgY = padY + innerH - (avg / maxValue) * innerH;
  const avgLine = document.createElementNS('http://www.w3.org/2000/svg', 'line');
  avgLine.setAttribute('x1', String(padX));
  avgLine.setAttribute('x2', String(padX + innerW));
  avgLine.setAttribute('y1', String(avgY));
  avgLine.setAttribute('y2', String(avgY));
  avgLine.setAttribute('stroke', '#60a5fa');
  avgLine.setAttribute('stroke-width', '1.2');
  avgLine.setAttribute('stroke-dasharray', '5 4');
  svgEl.appendChild(avgLine);

  points.forEach((p) => {
    const dot = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    dot.setAttribute('cx', String(p.x));
    dot.setAttribute('cy', String(p.y));
    dot.setAttribute('r', '3');
    dot.setAttribute('fill', '#0b0b0b');
    dot.setAttribute('stroke', '#D4AF37');
    dot.setAttribute('stroke-width', '1.5');
    svgEl.appendChild(dot);

    const label = document.createElementNS('http://www.w3.org/2000/svg', 'text');
    label.setAttribute('x', String(p.x));
    label.setAttribute('y', String(h - 8));
    label.setAttribute('text-anchor', 'middle');
    label.setAttribute('fill', '#9ca3af');
    label.setAttribute('font-size', '10');
    label.textContent = p.label.slice(5).replace('/', '-');
    svgEl.appendChild(label);
  });
}

function renderLegalOverviewCharts() {
  const signalDonut = document.getElementById('legal-signal-donut');
  const signalLegend = document.getElementById('legal-signal-legend');
  const trendRoot = document.getElementById('legal-trend-chart');
  const categoryRoot = document.getElementById('legal-category-chart');
  if (!signalDonut || !signalLegend || !trendRoot || !categoryRoot) return;

  const consultations = (AUX_RECORDS_CONFIG.consultations && AUX_RECORDS_CONFIG.consultations.data) || [];
  const owners = (AUX_RECORDS_CONFIG.owners && AUX_RECORDS_CONFIG.owners.data) || [];
  const attachments = (AUX_RECORDS_CONFIG.attachments && AUX_RECORDS_CONFIG.attachments.data) || [];

  const typeCounts = {};
  consultations.forEach((row) => {
    const type = (row && row.signalType) ? row.signalType : 'غير محدد';
    typeCounts[type] = (typeCounts[type] || 0) + 1;
  });
  const signalRows = Object.entries(typeCounts)
    .map(([label, value]) => ({ label, value }))
    .sort((a, b) => b.value - a.value)
    .slice(0, 6);

  renderLegalDonut(signalDonut, signalLegend, signalRows);

  const monthCounts = {};
  [...owners, ...consultations, ...attachments].forEach((row) => {
    if (!row || typeof row.createdAt !== 'string') return;
    const monthKey = row.createdAt.slice(0, 7);
    if (!/^\d{4}-\d{2}$/.test(monthKey)) return;
    monthCounts[monthKey] = (monthCounts[monthKey] || 0) + 1;
  });
  const monthlyRows = Object.entries(monthCounts)
    .sort(([a], [b]) => a.localeCompare(b))
    .slice(-6)
    .map(([month, value]) => ({ label: month.replace('-', '/'), value }));

  renderLegalTrend(trendRoot, monthlyRows);

  renderSimpleBars(categoryRoot, [
    { label: 'المالك', value: owners.length },
    { label: 'استشارات', value: consultations.length },
    { label: 'ملحقات', value: attachments.length }
  ], [
    'linear-gradient(180deg, var(--gold-bright), var(--gold-deep))',
    'linear-gradient(180deg, #60a5fa, #2563eb)',
    'linear-gradient(180deg, #34d399, #059669)'
  ]);

  const totalLegalRecords = owners.length + consultations.length + attachments.length;
  const uniqueUsers = new Set(
    [...owners, ...consultations, ...attachments]
      .map(r => (r && r.enteredBy) ? r.enteredBy : '')
      .filter(Boolean)
  );
  const latestDate = [...owners, ...consultations, ...attachments]
    .map(r => (r && typeof r.createdAt === 'string') ? r.createdAt : '')
    .filter(Boolean)
    .sort()
    .slice(-1)[0] || '';

  const kpiTotal = document.getElementById('legal-kpi-total');
  const kpiSignals = document.getElementById('legal-kpi-signals');
  const kpiUsers = document.getElementById('legal-kpi-users');
  const kpiLatest = document.getElementById('legal-kpi-latest');
  if (kpiTotal) kpiTotal.textContent = totalLegalRecords.toLocaleString('ar-SA');
  if (kpiSignals) kpiSignals.textContent = consultations.length.toLocaleString('ar-SA');
  if (kpiUsers) kpiUsers.textContent = uniqueUsers.size.toLocaleString('ar-SA');
  if (kpiLatest) kpiLatest.textContent = latestDate ? latestDate.replace(/-/g, '/') : '—';

  const signalNote = document.getElementById('legal-signal-type-note');
  if (signalNote) {
    signalNote.textContent = `السجل الأعلى: ${owners.length >= consultations.length && owners.length >= attachments.length ? 'المالك' : consultations.length >= attachments.length ? 'الإشارات' : 'الملحقات'} • إجمالي التقارير: ${totalLegalRecords.toLocaleString('ar-SA')}`;
  }
  const monthlyNote = document.getElementById('legal-monthly-note');
  if (monthlyNote) {
    const avgMonthly = monthlyRows.length ? (monthlyRows.reduce((s, r) => s + r.value, 0) / monthlyRows.length) : 0;
    monthlyNote.textContent = `متوسط الإدخال الشهري: ${avgMonthly.toFixed(1)} تقرير`;
  }
}

function collectAllPropertySignals() {
  const rows = [];
  buildings.forEach((b) => {
    const propertySignals = Array.isArray(b.signals) ? b.signals : [];
    propertySignals.forEach((s, idx) => {
      rows.push({
        signalNo: s.signalId || s.no || `SIG-${idx + 1}`,
        date: s.date || '',
        type: s.type || 'غير محدد',
        owners: Array.isArray(s.owners) ? s.owners : [],
        defendants: Array.isArray(s.defendants) ? s.defendants : [],
        mahder: b.mahder || 'غير محدد',
        propertyNo: b.propNo || '—'
      });
    });
  });
  return rows;
}

function renderLegalRequestedCharts() {
  const signals = collectAllPropertySignals();
  const sideRoot = document.getElementById('legal-side-count-chart');
  const lastFiveBody = document.getElementById('legal-last-five-signals-body');
  const topMahderRoot = document.getElementById('legal-top-mahder-chart');
  const topOwnerRoot = document.getElementById('legal-top-owner-chart');
  const topDefRoot = document.getElementById('legal-top-defendant-chart');
  if (!sideRoot || !lastFiveBody || !topMahderRoot || !topOwnerRoot || !topDefRoot) return;

  const ownersMentions = signals.reduce((sum, s) => sum + (s.owners.length || 0), 0);
  const defendantsMentions = signals.reduce((sum, s) => sum + (s.defendants.length || 0), 0);
  renderSimpleBars(sideRoot, [
    { label: 'صاحب الإشارة', value: ownersMentions },
    { label: 'المدعى عليه', value: defendantsMentions }
  ], [
    'linear-gradient(180deg, #34d399, #059669)',
    'linear-gradient(180deg, #f87171, #b91c1c)'
  ]);

  const lastFive = [...signals]
    .sort((a, b) => (a.date || '').localeCompare(b.date || ''))
    .slice(-5)
    .reverse();
  lastFiveBody.innerHTML = '';
  if (!lastFive.length) {
    lastFiveBody.innerHTML = '<tr><td colspan="4">لا توجد إشارات حتى الآن.</td></tr>';
  } else {
    lastFive.forEach((s) => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${s.signalNo}</td>
        <td>${s.date || '—'}</td>
        <td>${s.mahder}</td>
        <td>${s.type}</td>
      `;
      lastFiveBody.appendChild(tr);
    });
  }

  const mahderCount = {};
  signals.forEach((s) => {
    mahderCount[s.mahder] = (mahderCount[s.mahder] || 0) + 1;
  });
  const topMahders = Object.entries(mahderCount)
    .map(([label, value]) => ({ label, value }))
    .sort((a, b) => b.value - a.value)
    .slice(0, 6);
  renderSimpleBars(topMahderRoot, topMahders, [
    'linear-gradient(180deg, var(--gold-bright), var(--gold-deep))'
  ]);

  const ownerCount = {};
  signals.forEach((s) => s.owners.forEach((name) => {
    ownerCount[name] = (ownerCount[name] || 0) + 1;
  }));
  const topOwners = Object.entries(ownerCount)
    .map(([label, value]) => ({ label, value }))
    .sort((a, b) => b.value - a.value)
    .slice(0, 6);
  renderSimpleBars(topOwnerRoot, topOwners, [
    'linear-gradient(180deg, #34d399, #059669)'
  ]);

  const defendantCount = {};
  signals.forEach((s) => s.defendants.forEach((name) => {
    defendantCount[name] = (defendantCount[name] || 0) + 1;
  }));
  const topDefendants = Object.entries(defendantCount)
    .map(([label, value]) => ({ label, value }))
    .sort((a, b) => b.value - a.value)
    .slice(0, 6);
  renderSimpleBars(topDefRoot, topDefendants, [
    'linear-gradient(180deg, #f87171, #b91c1c)'
  ]);
}

function renderGeneralOverviewCharts() {
  const totalEl = document.getElementById('general-kpi-properties');
  const fullOwnedEl = document.getElementById('general-kpi-full-owned');
  const avgShareEl = document.getElementById('general-kpi-avg-share');
  const ownerShareRoot = document.getElementById('general-owner-share-chart');
  const ownerShareNote = document.getElementById('general-owner-share-note');
  if (!totalEl || !fullOwnedEl || !avgShareEl || !ownerShareRoot || !ownerShareNote) return;

  const totalProperties = buildings.length;
  const fullyOwned = buildings.filter((b) => Number(b.share) >= 100).length;
  const avgShare = totalProperties
    ? buildings.reduce((sum, b) => sum + (Number(b.share) || 0), 0) / totalProperties
    : 0;

  totalEl.textContent = totalProperties.toLocaleString('ar-SA');
  fullOwnedEl.textContent = fullyOwned.toLocaleString('ar-SA');
  avgShareEl.textContent = `${avgShare.toFixed(1)}%`;

  const ownerCount = {};
  collectAllPropertySignals().forEach((s) => {
    s.owners.forEach((name) => {
      ownerCount[name] = (ownerCount[name] || 0) + 1;
    });
  });
  const rows = Object.entries(ownerCount)
    .map(([label, value]) => ({ label, value }))
    .sort((a, b) => b.value - a.value)
    .slice(0, 6);
  renderSimpleBars(ownerShareRoot, rows, [
    'linear-gradient(180deg, #60a5fa, #2563eb)',
    'linear-gradient(180deg, #34d399, #059669)'
  ]);
  ownerShareNote.textContent = `عدد المالكين الظاهرين في الإشارات: ${Object.keys(ownerCount).length.toLocaleString('ar-SA')}`;
}

function areaLabelForCard() {
  return getPrefs().area === 'ft2' ? 'المساحة الكلية (قدم²)' : 'المساحة الكلية (م²)';
}

function portfolioShareLabel(pct) {
  const p = getPrefs();
  if (p.ownership === 'sahm') {
    const shares = Math.round((pct / 100) * 2400);
    return shares.toLocaleString('ar-SA') + ' سهم من ٢٤٠٠';
  }
  return pct + '٪ من المساحة الكلية';
}

// Mobile/tablet layout mode:
// - phones (<= 700px)
// - tablets in portrait (<= 1024px + portrait)
function isMobileNavMode() {
  return (
    window.matchMedia('(max-width: 700px)').matches ||
    window.matchMedia('(max-device-width: 700px)').matches ||
    (window.matchMedia('(max-width: 1024px) and (orientation: portrait)').matches) ||
    (window.matchMedia('(max-device-width: 1024px) and (orientation: portrait)').matches)
  );
}

let propertyTableView = 'horizontal'; // for tablets portrait: horizontal by default

function applyPropertyTableView(view) {
  const card = document.getElementById('property-table-card');
  if (!card) return;

  propertyTableView = view === 'vertical' ? 'vertical' : 'horizontal';
  card.classList.toggle('property-table--vertical', propertyTableView === 'vertical');

  const btn = document.getElementById('mobile-table-view-toggle');
  if (btn) {
    btn.textContent = propertyTableView === 'vertical' ? 'عرض أفقي' : 'عرض عمودي';
  }
}

function togglePropertyTableView() {
  applyPropertyTableView(propertyTableView === 'vertical' ? 'horizontal' : 'vertical');
}

function initPropertyTableView() {
  // Cards/vertical rows already happen on phones via CSS media query, so keep default horizontal for tablets.
  // If you want vertical as default for tablets too, change 'horizontal' to 'vertical' below.
  applyPropertyTableView('horizontal');

  // On phones, add a one-time swipe hint on the table overflow container
  if (window.matchMedia('(max-width: 600px)').matches) {
    const overflow = document.querySelector('.table-overflow');
    if (overflow && !overflow.dataset.hintAdded) {
      overflow.dataset.hintAdded = '1';
      const hint = document.createElement('div');
      hint.id = 'swipe-hint';
      hint.style.cssText = [
        'display:flex', 'align-items:center', 'justify-content:center',
        'gap:8px', 'padding:8px 14px',
        'background:rgba(212,175,55,.07)', 'border-bottom:1px solid rgba(212,175,55,.15)',
        'font-family:var(--font-ui)', 'font-size:calc(11px * var(--fs-scale))', 'color:var(--gold-mid)',
        'letter-spacing:.04em', 'animation:fadeSlide .4s ease'
      ].join(';');
      hint.innerHTML = '← اسحب يساراً لرؤية بقية الأعمدة →';
      overflow.parentElement.insertBefore(hint, overflow);
      // Dismiss after first scroll
      overflow.addEventListener('scroll', function dismissHint() {
        const h = document.getElementById('swipe-hint');
        if (h) { h.style.transition = 'opacity .4s'; h.style.opacity = '0'; setTimeout(() => h.remove(), 400); }
        overflow.removeEventListener('scroll', dismissHint);
      });
    }
  }
}

function updateSelectedCount() {
  const el = document.getElementById('selected-count');
  if (!el) return;
  const count = buildings.filter(b => selectedProps.has(b.propNo)).length;
  el.textContent = count;
}

function updateSelectColumnVisibility() {
  const table = document.getElementById('main-table');
  if (!table) return;
  table.classList.toggle('hide-select', !multiSelectEnabled);
}

function statusBadge(s) {
  const map = { 'نشط': 'status-active', 'جزئي': 'status-partial', 'قيد المراجعة': 'status-pending' };
  const dot = { 'نشط': '●', 'جزئي': '◑', 'قيد المراجعة': '○' };
  return `<span class="status-badge ${map[s]}">${dot[s]} ${s}</span>`;
}

function buildPaymentPanel(b) {
  var pays = Array.isArray(b.paymentsUsd) && b.paymentsUsd.length ? b.paymentsUsd : [];
  var totalVal = Number(b.approxPriceUsd) || Number(b.actualPriceUsd) || Number(b.value) || 0;
  var paidAmt = pays.reduce(function(s,p){ return s + (Number(p.amountUsd)||0); }, 0);
  var remAmt = Math.max(0, totalVal - paidAmt);
  var pct = totalVal > 0 ? Math.min(100, Math.round(paidAmt / totalVal * 100)) : 0;
  var statusColor = b.paymentFinanceStatus === 'مدفوع بشكل كامل' ? '#4ade80' : pct >= 50 ? '#fbbf24' : '#94a3b8';
  var now = new Date().toISOString().slice(0,10);
  function fmtAmt(v) { return v > 0 ? Number(v).toLocaleString('en-US') + ' $' : '—'; }
  // Summary cards
  var cards = ''
    + '<div style="flex:1;min-width:140px;background:rgba(212,175,55,.05);border:1px solid rgba(212,175,55,.18);border-radius:10px;padding:12px 16px">'
    +   '<div style="font-size:calc(10px * var(--fs-scale));color:var(--text-muted);margin-bottom:4px">القيمة الكلية</div>'
    +   '<div style="font-size:calc(15px * var(--fs-scale));font-weight:700;color:var(--text-primary);direction:ltr">' + fmtAmt(totalVal) + '</div>'
    + '</div>'
    + '<div style="flex:1;min-width:140px;background:rgba(74,222,128,.05);border:1px solid rgba(74,222,128,.18);border-radius:10px;padding:12px 16px">'
    +   '<div style="font-size:calc(10px * var(--fs-scale));color:var(--text-muted);margin-bottom:4px">المدفوع حتى الآن</div>'
    +   '<div style="font-size:calc(15px * var(--fs-scale));font-weight:700;color:#4ade80;direction:ltr">' + fmtAmt(paidAmt) + '</div>'
    + '</div>'
    + '<div style="flex:1;min-width:140px;background:rgba(251,191,36,.05);border:1px solid rgba(251,191,36,.18);border-radius:10px;padding:12px 16px">'
    +   '<div style="font-size:calc(10px * var(--fs-scale));color:var(--text-muted);margin-bottom:4px">المتبقي</div>'
    +   '<div style="font-size:calc(15px * var(--fs-scale));font-weight:700;direction:ltr;color:' + (remAmt > 0 ? '#fbbf24' : '#4ade80') + '">' + (remAmt > 0 ? fmtAmt(remAmt) : '✓ مكتمل') + '</div>'
    + '</div>';
  // Progress bar
  var progress = ''
    + '<div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:calc(10.5px * var(--fs-scale));color:var(--text-muted)">'
    +   '<span>نسبة السداد</span>'
    +   '<span style="color:' + statusColor + ';font-weight:600">' + pct + '%</span>'
    + '</div>'
    + '<div style="height:6px;border-radius:6px;background:rgba(255,255,255,.06);overflow:hidden">'
    +   '<div style="height:100%;width:' + pct + '%;background:linear-gradient(to left,' + statusColor + ',' + statusColor + '88);border-radius:6px"></div>'
    + '</div>';
  // Payment rows
  var tblRows = '';
  if (pays.length) {
    pays.forEach(function(p) {
      var isPast = p.date && p.date <= now;
      var dot = isPast ? '✓' : '○';
      var dotClr = isPast ? '#4ade80' : '#94a3b8';
      var rowClr = isPast ? 'var(--gold-light)' : 'var(--text-secondary)';
      var pillBg = isPast ? 'rgba(74,222,128,.1)' : 'rgba(148,163,184,.08)';
      var pillClr = isPast ? '#4ade80' : '#94a3b8';
      var pillBdr = isPast ? 'rgba(74,222,128,.2)' : 'rgba(148,163,184,.15)';
      tblRows += '<tr>'
        + '<td style="padding:8px 12px;border-bottom:1px solid rgba(42,42,42,.5);font-family:var(--font-ui);font-size:calc(10.5px * var(--fs-scale));color:' + dotClr + ';text-align:center">' + dot + '</td>'
        + '<td style="padding:8px 12px;border-bottom:1px solid rgba(42,42,42,.5);font-variant-numeric:tabular-nums;direction:ltr;color:var(--text-muted);font-size:calc(11px * var(--fs-scale))">' + escapeCellHtml(p.date||'') + '</td>'
        + '<td style="padding:8px 12px;border-bottom:1px solid rgba(42,42,42,.5);font-weight:600;color:' + rowClr + ';font-size:calc(12px * var(--fs-scale));font-variant-numeric:tabular-nums;direction:ltr">' + fmtAmt(p.amountUsd) + '</td>'
        + '<td style="padding:8px 12px;border-bottom:1px solid rgba(42,42,42,.5)">'
        +   '<span style="font-size:calc(10px * var(--fs-scale));padding:2px 8px;border-radius:20px;background:' + pillBg + ';color:' + pillClr + ';border:1px solid ' + pillBdr + '">' + (isPast ? 'مسدَّدة' : 'معلَّقة') + '</span>'
        + '</td>'
        + '</tr>';
    });
  } else {
    tblRows = '<tr><td colspan="4" style="padding:10px;text-align:center;color:var(--text-muted)">' + escapeCellHtml(b.paymentDetailBlurb || String(b.payments || '—')) + '</td></tr>';
  }
  var tbl = pays.length
    ? ('<div style="border:1px solid var(--border);border-radius:10px;overflow:hidden">'
      + '<table style="width:100%;border-collapse:collapse">'
      + '<thead><tr style="background:rgba(0,0,0,.25)">'
      + '<th style="padding:8px 12px;font-size:calc(10px * var(--fs-scale));color:var(--text-muted);font-weight:600;text-align:center;width:32px"></th>'
      + '<th style="padding:8px 12px;font-size:calc(10px * var(--fs-scale));color:var(--text-muted);font-weight:600;text-align:right">تاريخ الدفعة</th>'
      + '<th style="padding:8px 12px;font-size:calc(10px * var(--fs-scale));color:var(--text-muted);font-weight:600;text-align:right">المبلغ</th>'
      + '<th style="padding:8px 12px;font-size:calc(10px * var(--fs-scale));color:var(--text-muted);font-weight:600;text-align:right">الحالة</th>'
      + '</tr></thead>'
      + '<tbody>' + tblRows + '</tbody>'
      + '</table></div>')
    : '';
  return '<div style="display:flex;flex-direction:column;gap:16px;max-width:680px">'
    + '<div style="display:flex;flex-wrap:wrap;gap:12px">' + cards + '</div>'
    + '<div>' + progress + '</div>'
    + tbl
    + '</div>';
}

function renderTable() {
  const tbody = document.getElementById('table-body');
  if (!tbody) {
    console.warn('[Alrowad] عنصر الجدول #table-body غير موجود بعد — لم يُعرَض تقرير العقارات بعد.');
    return;
  }
  const total = filteredData.length;
  const perPage = rowsLimit === 'all' ? (total || 1) : rowsLimit;
  const totalPages = Math.max(1, Math.ceil(total / perPage));
  if (currentPage > totalPages) currentPage = totalPages;
  const start = rowsLimit === 'all' ? 0 : (currentPage - 1) * perPage;
  const end = rowsLimit === 'all' ? total : start + perPage;
  const visible = filteredData.slice(start, end);
  const spanCols = getVisiblePropertyColCount();
  tbody.innerHTML = visible.map((b, idx) => {
    const isSelected = selectedProps.has(b.propNo);
    const bi = buildings.indexOf(b);
    const propertyKind = getPropertyKindOfBuilding(b, bi);
    const propertySubType = getPropertySubTypeOfBuilding(b, bi);
    const pid = b.propId;
    const om = getAuxOwnerRowMap();
    const stakes = b.propertyOwners || [];
    let ownersCellHtml = '';
    // ── Owner cell helpers ──────────────────────────────
    const PALETTE_SIZE = 5;
    const pocInitials = nm => {
      const clean = nm.replace(/^(د\.?|أ\.?|م\.?)\s+/, '').trim();
      const parts = clean.split(/\s+/);
      return parts.length >= 2
        ? (parts[0][0] + parts[1][0])
        : (parts[0] || '?')[0];
    };
    const pocPct = rawShare => {
      if (!rawShare && rawShare !== 0) return '';
      const full = formatStakeForDisplay(rawShare);
      const m = full.match(/^(\d+)\//);
      if (!m) return full;
      const n = parseInt(m[1], 10);
      // Respect the ownership display mode set in لوحة الاعدادات السريعة
      if (getPrefs().ownership === 'pct') {
        if (n === 2400) return '100%';
        const p = n / 2400 * 100;
        return (Number.isInteger(p) ? p : +p.toFixed(1)) + '%';
      }
      return n.toLocaleString('en-US') + ' سهم';
    };
    const pocAvatar = (nm, colorIdx) => {
      const ci = colorIdx % PALETTE_SIZE;
      return '<div class="poc-av poc-av-' + ci + '" aria-hidden="true"></div>';
    };
    // Single-owner card
    const pocSingleCard = (po, nm, colorIdx) => {
      const ci = colorIdx % PALETTE_SIZE;
      const pct = pocPct(po.share);
      return '<div class="poc-card">'
        + pocAvatar(nm, ci)
        + '<button type="button" class="poc-nm" data-poc-id="' + escapeCellHtml(po.ownerId) + '" onclick="pocNav(this)" title="' + escapeCellHtml(nm) + '">' + escapeCellHtml(nm) + '</button>'
        + (pct ? '<span class="poc-pct poc-pct-' + ci + '">' + pct + '</span>' : '')
        + '</div>';
    };
    // Multi-owner: show every owner as its own compact card, stacked
    const pocCluster = (stks, ownerMap) => {
      const cards = stks.map((po, i) => {
        const r = ownerMap[po.ownerId];
        const nm = r ? r.ownerName : po.holderName || po.ownerId;
        return pocSingleCard(po, nm, i);
      }).join('');
      return '<div class="poc-stack">' + cards + '</div>';
    };
    // ── Render ────────────────────────────────────────
    if (!stakes.length) {
      const fallback = getResponsiblePersonOfBuilding(b, bi) || '—';
      const ini = (fallback.replace(/^(د\.?|أ\.?|م\.?)\s+/,'').trim()[0] || '?').toUpperCase();
      ownersCellHtml = '<div class="poc-card"><div class="poc-av poc-av-muted" aria-hidden="true">' + ini + '</div>'
        + '<span class="poc-nm poc-nm--plain" title="' + escapeCellHtml(fallback) + '">' + escapeCellHtml(fallback) + '</span></div>';
    } else if (stakes.length === 1) {
      const x = stakes[0];
      const rowm = om[x.ownerId];
      const nm = rowm ? rowm.ownerName : x.holderName || x.ownerId;
      ownersCellHtml = pocSingleCard(x, nm, 0);
    } else {
      ownersCellHtml = pocCluster(stakes, om);
    }
    const approxVal = Number(b.approxPriceUsd);
    const actVal = Number(b.actualPriceUsd != null ? b.actualPriceUsd : b.value);
    const fmtUsd = v => (isFinite(v) ? `<span class="price-cell price-approx"><span class="price-cur">$</span><span class="price-amount">${Number(v).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}</span></span>` : '<span class="price-empty">—</span>');
    const sigAux = propertySignalsFromAux(pid);
    const attAux = propertyAttachmentsFromAux(pid);
    const stakeTbl = stakes.length <= 1 ? ''
      : `<div class="prop-owner-stake-list">${stakes.map(po => {
        const rr = om[po.ownerId];
        const nm = rr ? rr.ownerName : po.holderName || po.ownerId;
        return `<div class="prop-owner-stake-row"><button type="button" class="geo-link detail-deep-link prop-owner-name-btn" onclick="jumpLinkedRecord('owner','${po.ownerId}')" title="تقرير المالك">${escapeCellHtml(nm)}</button><span class="prop-owner-stake" title="الحصة من 2400 سهمًا">${escapeCellHtml(formatStakeForDisplay(po.share))}</span></div>`;
      }).join('')}</div>`;
    const geoOpen = isPropertyExpandOpen(pid, 'geo');
    const notesOpen = isPropertyExpandOpen(pid, 'pnotes');
    const payOpen      = isPropertyExpandOpen(pid, 'paydet');
    const areaBreakOpen = isPropertyExpandOpen(pid, 'areaBreak');
    const ownStakeOpen = isPropertyExpandOpen(pid, 'ownStake');
    const rawGeo = String(b.geo || '').trim();
    const iframeSrc = /^https:\/\/www\.google\.com\/maps\/embed/i.test(rawGeo)
      ? rawGeo
      : ('https://maps.google.com/maps?q=' + encodeURIComponent(`${b.city || ''} ${b.name || ''}`.trim()) + '&output=embed');
    const iframeSafeAttr = iframeSrc.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;');
    const mapBlock = !rawGeo
      ? '<div style="color:var(--text-muted);padding:12px;text-align:center">لا يوجد رابط موقع لهذا السجل.</div>'
      : `<div style="display:flex;flex-direction:column;gap:12px;align-items:stretch;">
          <iframe title="موقع على خرائط Google" loading="lazy" style="border:0;width:100%;min-height:260px;border-radius:8px;background:#111827" referrerpolicy="no-referrer-when-downgrade" src="${iframeSafeAttr}"></iframe>
          <div style="text-align:center"><a href="${escapeCellHtml(rawGeo)}" target="_blank" rel="noopener noreferrer" class="geo-link">فتح الرابط المحفوظ للموقع الجغرافي</a></div>
        </div>`;
    const sigPanel = !sigAux.length
      ? '<div style="color:var(--text-muted);padding:6px 0">لا توجد إشارات مرتبطة في تقرير الإشارات.</div>'
      : sigAux.map((s, si) => {
          const claimants = auxFormatOwnerLabels(s.claimantOwnerIds || []).join('، ');
          const defendants = auxFormatOwnerLabels((s.defendantOwnerIds || []).filter(Boolean)).join('، ') || '—';
          return `<div style="margin-bottom:10px;padding:12px 14px;border-radius:10px;border:1px solid rgba(212,175,55,.2);background:linear-gradient(135deg,rgba(212,175,55,.05),rgba(0,0,0,.15));line-height:1.65">
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:6px;margin-bottom:8px">
              <span style="font-family:var(--font-ui);font-weight:700;color:var(--gold-mid);font-size:calc(12px * var(--fs-scale))">${escapeCellHtml(s.signalId)}</span>
              <span style="background:rgba(212,175,55,.1);border:1px solid rgba(212,175,55,.2);border-radius:20px;padding:2px 10px;font-size:calc(10.5px * var(--fs-scale));color:var(--gold-light);white-space:nowrap">${escapeCellHtml(s.signalType)}</span>
            </div>
            <div style="font-size:calc(11.5px * var(--fs-scale));color:var(--text-secondary);margin-bottom:6px">
              <span style="color:var(--text-muted)">رقم العقد:</span> ${escapeCellHtml(s.signalContractNo)}
              <span style="margin:0 6px;color:var(--text-muted)">•</span>
              <span style="color:var(--text-muted)">التاريخ:</span> ${escapeCellHtml(s.signalDate)}
            </div>
            <div style="font-size:calc(11px * var(--fs-scale));color:var(--text-muted);margin-bottom:10px;line-height:1.5">
              <span>الأطراف:</span> <span style="color:var(--text-secondary)">${escapeCellHtml(claimants)}</span>
              <span style="margin:0 4px">ضد</span>
              <span style="color:var(--text-secondary)">${escapeCellHtml(defendants)}</span>
            </div>
            <button type="button" class="detail-deep-link" onclick="jumpLinkedRecord('consultation','${s.signalId}')" title="فتح في تقرير الإشارات" style="font-size:calc(11.5px * var(--fs-scale))">↪ الانتقال لتقرير الإشارات</button>
          </div>`;
        }).join('');
    const attPanel = !attAux.length
      ? '<div style="color:var(--text-muted);padding:6px 0">لا توجد ملحقات مرتبطة في تقرير الملحقات.</div>'
      : attAux.map((a, ai) =>
          `<div style="display:flex;align-items:center;gap:10px;padding:8px 12px;margin-bottom:6px;border-radius:8px;border:1px solid rgba(212,175,55,.15);background:rgba(212,175,55,.03)">
            <span style="flex:0 0 auto;width:28px;height:28px;display:flex;align-items:center;justify-content:center;border-radius:50%;background:rgba(212,175,55,.1);border:1px solid rgba(212,175,55,.2);color:var(--gold-mid);font-size:calc(11px * var(--fs-scale));font-weight:700">${ai+1}</span>
            <div style="flex:1;min-width:0">
              <button type="button" class="detail-deep-link" onclick="jumpLinkedRecord('attachment','${a.attachmentId}')" title="تقرير الملحقات" style="font-size:calc(12px * var(--fs-scale));display:block;text-align:start;width:100%">${escapeCellHtml(a.attachmentName)}</button>
              <div style="font-size:calc(10.5px * var(--fs-scale));color:var(--text-muted);margin-top:2px">${escapeCellHtml(a.attachmentId)}${a.attachmentNo ? ' · ' + escapeCellHtml(a.attachmentNo) : ''}</div>
            </div>
          </div>`
        ).join('');
    const createdShown = b.createdAt || getRegistrationDateOfBuilding(b, bi);
    return `<tr class="${isSelected ? 'selected-row' : ''}" data-prop-id="${escapeCellHtml(pid || '')}">
      <td class="select-col" style="text-align:center">
        ${multiSelectEnabled ? `<input type="checkbox" class="row-select" onchange="toggleRowSelection('${b.propNo}', this.checked, this)" ${selectedProps.has(b.propNo) ? 'checked' : ''} />` : ''}</td>
      <td class="td-seq col-seq"><span class="id-badge">${escapeCellHtml(pid || String(idx + 1))}</span></td>
      <td class="col-propnoMahder">${propCombo(b)}</td>
      <td class="col-propOwners">${ownersCellHtml}</td>
      <td class="col-country">${escapeCellHtml(getCountryOfBuilding(b))}</td>
      <td class="col-city">${escapeCellHtml(b.city)}</td>
      <td class="col-type">${escapeCellHtml(propertyKind + (propertySubType ? ' — ' + propertySubType : ''))}</td>
      <td class="col-owndate">${escapeCellHtml(b.ownDate || '—')}</td>
      <td class="col-area" style="text-align:center">
        ${stakes.length > 0
          ? `<button type="button" class="area-expand-btn" onclick="togglePropertyExpand('${pid}','areaBreak')">
               <span class="area-expand-val">${escapeCellHtml(formatAreaFromM2(Number(b.area) || 0))}</span>
               <span class="area-expand-caret">${areaBreakOpen ? '▴' : '▾'}</span>
             </button>`
          : `<span>${escapeCellHtml(formatAreaFromM2(Number(b.area) || 0))}</span>`
        }
      </td>
      <td class="col-geo" style="text-align:center">
        <button type="button" class="geo-link" title="عرض الخريطة" onclick="togglePropertyExpand('${pid}','geo')">${geoOpen ? '🗺▴' : '🗺▾'}</button>
      </td>
      <td class="col-propNotes" style="text-align:center">
        <button type="button" class="details-toggle" onclick="togglePropertyExpand('${pid}','pnotes')"><span>ملاحظات</span><span>${notesOpen ? '▴' : '▾'}</span></button></td>
      <td class="col-opstatus">${operationalStatusBadge(b.operationalStatus)}</td>
      <td class="col-approxprice">${fmtUsd(approxVal)}</td>
      <td class="col-actualprice">${fmtUsd(actVal)}</td>
      <td class="col-payfinance">${(()=>{
        const s = b.paymentFinanceStatus || '—';
        const cls = s === 'مدفوع بشكل كامل' ? 'pay-status-full' : s === 'جزئي' ? 'pay-status-partial' : 'pay-status-other';
        const dot = s === 'مدفوع بشكل كامل' ? '●' : s === 'جزئي' ? '◑' : '○';
        return `<span class="pay-status-badge ${cls}">${dot} ${escapeCellHtml(s)}</span>`;
      })()}</td>
      <td class="col-paydetail" style="text-align:center">
        <button type="button" class="details-toggle" onclick="togglePropertyExpand('${pid}','paydet')"><span>تفاصيل الدفعات</span><span>${payOpen ? '▴' : '▾'}</span></button></td>
      <td class="col-view" style="text-align:center">
        <button class="eye-btn" type="button" onclick="openPropertyDetails('${b.propNo}')">👁</button>
      </td>
      <td class="col-propEntered">${escapeCellHtml(getEnteredByOfBuilding(b, bi))}</td>
      <td class="col-propCreated">${escapeCellHtml(createdShown)}</td>
      <td class="col-propUpdated">${escapeCellHtml(b.updatedAt || '')}</td>
    </tr>

    <tr class="detail-row ${geoOpen ? 'open' : ''}"><td class="detail-cell" colspan="${spanCols}"><div class="detail-map-title" style="margin-bottom:10px">${escapeCellHtml(b.name)}</div>${mapBlock}</td></tr>
    <tr class="detail-row ${notesOpen ? 'open' : ''}"><td class="detail-cell" colspan="${spanCols}">
      <div class="property-notes-wrap">
        <p class="property-notes-text">${escapeCellHtml((b.details || 'لا توجد ملاحظة نصية — راجع الوصف أسفل عنوان العقار.').slice(0, 2000))}</p>
        <div class="property-notes-grid">
          <section class="property-notes-card">
            <div class="property-notes-card-title">الإشارات المرتبطة (${sigAux.length})</div>
            ${sigPanel}
          </section>
          <section class="property-notes-card">
            <div class="property-notes-card-title">الملحقات المرتبطة (${attAux.length})</div>
            ${attPanel}
          </section>
        </div>
      </div></td></tr>
    <tr class="detail-row ${payOpen ? 'open' : ''}"><td class="detail-cell" colspan="${spanCols}">${buildPaymentPanel(b)}</td></tr>
    <tr class="detail-row ${areaBreakOpen ? 'open' : ''}"><td class="detail-cell" colspan="${spanCols}">
      <div class="area-break-panel">
        <div class="area-break-header">
          <span>توزيع مساحة العقار على الملاك</span>
          <span class="area-break-total">${escapeCellHtml(formatAreaFromM2(Number(b.area) || 0))} إجمالي</span>
        </div>
        ${stakes.map((po, pi) => {
          const r = om[po.ownerId];
          const nm = r ? r.ownerName : po.holderName || po.ownerId;
          const full = formatStakeForDisplay(po.share);
          const shareM = full.match(/^(\d+)\/2400/);
          const shares = shareM ? parseInt(shareM[1], 10) : 0;
          const ownerArea = shares > 0 ? (Number(b.area) || 0) * shares / 2400 : 0;
          const pct = shares > 0 ? +(shares / 2400 * 100).toFixed(1) : 0;
          const COLORS = ['#d4af37','#63b3ed','#9acd6e','#ed8936','#b794f6'];
          const col = COLORS[pi % COLORS.length];
          return `<div class="area-break-row">
            <div class="area-break-dot" style="background:${col}"></div>
            <div class="area-break-name">
              <button type="button" class="detail-deep-link" data-poc-id="${escapeCellHtml(po.ownerId)}" onclick="pocNav(this)">${escapeCellHtml(nm)}</button>
            </div>
            <div class="area-break-bar-wrap">
              <div class="area-break-bar" style="width:${pct}%;background:${col}22;border-color:${col}55"></div>
            </div>
            <div class="area-break-pct" style="color:${col}">${pct}%</div>
            <div class="area-break-value">${escapeCellHtml(formatAreaFromM2(ownerArea))}</div>
            <div class="area-break-shares" style="color:${col};background:${col}18;border:1px solid ${col}44">${shares} سهم</div>
          </div>`;
        }).join('')}
      </div>
    </td></tr>`;
  }).join('');
  updateSelectColumnVisibility();
  applyColumnOrder();
  applyColumnVisibility();
  setupColumnReorderHandlers();
  ensureColumnResizers('main-table', 'main-colgroup');
  bindColumnResizeHandlers('main-table', 'main-colgroup');
  updateSelectedCount();
  document.getElementById('row-count').textContent = buildings.length.toLocaleString('ar-SA');
  const pageInfo = document.getElementById('page-info');
  if (pageInfo) pageInfo.textContent = `صفحة ${total ? currentPage : 0} من ${total ? totalPages : 0}`;
  const rowsInput = document.getElementById('rows-input');
  if (rowsInput) rowsInput.value = rowsLimit === 'all' ? total : rowsLimit;
  syncAllPagesTableScrollState();
  requestFloatingTableHeadSync();
  updateTableScrollStartButtons();
  if (typeof updateAllTblNavPills === 'function') updateAllTblNavPills();
  if (typeof window._wireTblNavPills === 'function') window._wireTblNavPills();
  // Inject pin buttons (idempotent) and re-apply pinning after DOM settles
  requestAnimationFrame(() => {
    injectPinButtons(document.getElementById('main-table')?.parentElement);
    applyColumnPinning('main-table');
  });
}

function propCombo(b) {
  return `<div>${escapeCellHtml(b.propNo || '—')}</div><div style="color:var(--text-muted);font-size:calc(11px * var(--fs-scale))">${escapeCellHtml(b.mahder || '—')}</div>`;
}

/* ═══════════════════════════════════════════════════════════════
   GLOBAL SEARCH — syncs all 4 table search inputs and re-filters
   every table with the same query simultaneously.
═══════════════════════════════════════════════════════════════ */
var _gSearchLock = false;
function globalSearch(q) {
  if (_gSearchLock) return;
  _gSearchLock = true;
  // Sync all 4 search inputs
  var ids = ['table-search', 'owners-search', 'consultations-search', 'attachments-search'];
  ids.forEach(function(id) {
    var el = document.getElementById(id);
    if (el && el.value !== q) el.value = q;
  });
  // Sync aux state searchInput objects (in case they differ from DOM ids)
  ['owners', 'consultations', 'attachments'].forEach(function(pk) {
    var st = auxRecordStates[pk];
    if (st && st.searchInput && st.searchInput.value !== q) st.searchInput.value = q;
  });
  _gSearchLock = false;
  // Re-filter all tables
  filterTable();
  ['owners', 'consultations', 'attachments'].forEach(function(pk) {
    if (auxRecordStates[pk]) filterAuxRecords(pk);
  });
}

/* Build lookup caches used by enhanced cross-table search */
function _buildOwnerNameMap() {
  var map = {};
  var rows = (AUX_RECORDS_CONFIG.owners && AUX_RECORDS_CONFIG.owners.data) || [];
  rows.forEach(function(r) { if (r.ownerId) map[r.ownerId] = (r.ownerName || '').toLowerCase(); });
  return map;
}
function _buildSignalMap() {
  var map = {};
  var rows = (AUX_RECORDS_CONFIG.consultations && AUX_RECORDS_CONFIG.consultations.data) || [];
  rows.forEach(function(r) { if (r.signalId) map[r.signalId] = r; });
  return map;
}
function _buildAttachmentMap() {
  var map = {};
  var rows = (AUX_RECORDS_CONFIG.attachments && AUX_RECORDS_CONFIG.attachments.data) || [];
  rows.forEach(function(r) { if (r.attachmentId) map[r.attachmentId] = r; });
  return map;
}
function _buildPropertyMap() {
  var map = {};
  (buildings || []).forEach(function(b) { if (b.propId) map[b.propId] = b; });
  return map;
}

function filterTable() {
  const searchEl = document.getElementById('table-search');
  if (!searchEl) return;
  const q = (searchEl.value || '').toLowerCase();
  propCreatedFrom = (document.getElementById('prop-created-from') || {}).value || '';
  propCreatedTo = (document.getElementById('prop-created-to') || {}).value || '';
  propOwnFrom = (document.getElementById('prop-own-from') || {}).value || '';
  propOwnTo = (document.getElementById('prop-own-to') || {}).value || '';
  propEnteredBy = ((document.getElementById('prop-entered-by') || {}).value || '').trim().toLowerCase();
  propUpdatedFrom = (document.getElementById('prop-updated-from') || {}).value || '';
  propUpdatedTo = (document.getElementById('prop-updated-to') || {}).value || '';

  filteredData = buildings.filter(b => {
    const idx = buildings.indexOf(b);
    const country = getCountryOfBuilding(b);
    const propertyKind = getPropertyKindOfBuilding(b, idx);
    const propertySubType = getPropertySubTypeOfBuilding(b, idx);
    const payFin = String(b.paymentFinanceStatus || '').toLowerCase();
    const opSt = String(b.operationalStatus || '').toLowerCase();
    const ownerHay = JSON.stringify(b.propertyOwners || []).toLowerCase();
    // Build cross-table haystacks once per filterTable call (captured in closure)
    var ownerNameMap = typeof _ownerNameMapCache !== 'undefined' ? _ownerNameMapCache : {};
    var sigMapCache  = typeof _sigMapCache !== 'undefined' ? _sigMapCache : {};
    var attMapCache  = typeof _attMapCache !== 'undefined' ? _attMapCache : {};
    // Owner names from AUX owners table
    var linkedOwnerNames = '';
    if (Array.isArray(b.propertyOwners)) {
      b.propertyOwners.forEach(function(po) {
        var id = po.ownerId || po;
        if (ownerNameMap[id]) linkedOwnerNames += ' ' + ownerNameMap[id];
      });
    }
    // Signal data for this property (from AUX consultations)
    var sigHay = '';
    var allSigs = (AUX_RECORDS_CONFIG.consultations && AUX_RECORDS_CONFIG.consultations.data) || [];
    allSigs.forEach(function(s) {
      if ((s.propertyIds || []).includes(b.propId)) {
        sigHay += ' ' + JSON.stringify(s).toLowerCase();
      }
    });
    // Attachment data for this property (from AUX attachments)
    var attHay = '';
    var allAtts = (AUX_RECORDS_CONFIG.attachments && AUX_RECORDS_CONFIG.attachments.data) || [];
    allAtts.forEach(function(a) {
      if ((a.propertyIds || []).includes(b.propId)) {
        attHay += ' ' + JSON.stringify(a).toLowerCase();
      }
    });
    // Owner full records for this property
    var ownerFullHay = '';
    var allOwnRows = (AUX_RECORDS_CONFIG.owners && AUX_RECORDS_CONFIG.owners.data) || [];
    allOwnRows.forEach(function(o) {
      if ((o.propertyIds || []).includes(b.propId)) {
        ownerFullHay += ' ' + JSON.stringify(o).toLowerCase();
      }
    });
    const matchQ =
      !q ||
      (b.name && String(b.name).toLowerCase().includes(q)) ||
      (b.propNo && b.propNo.toLowerCase().includes(q)) ||
      (b.propId && String(b.propId).toLowerCase().includes(q)) ||
      (b.mahder && b.mahder.toLowerCase().includes(q)) ||
      (country && country.toLowerCase().includes(q)) ||
      (b.city && String(b.city).toLowerCase().includes(q)) ||
      (propertyKind && propertyKind.toLowerCase().includes(q)) ||
      (propertySubType && propertySubType.toLowerCase().includes(q)) ||
      (b.details && String(b.details).toLowerCase().includes(q)) ||
      (b.division && String(b.division).toLowerCase().includes(q)) ||
      (b.ownDate && b.ownDate.toLowerCase().includes(q)) ||
      (b.createdAt && b.createdAt.toLowerCase().includes(q)) ||
      (b.updatedAt && b.updatedAt.toLowerCase().includes(q)) ||
      (b.payments && String(b.payments).toLowerCase().includes(q)) ||
      (b.paymentDetailBlurb && String(b.paymentDetailBlurb).toLowerCase().includes(q)) ||
      (payFin && payFin.includes(q)) ||
      (opSt && opSt.includes(q)) ||
      ownerHay.includes(q) ||
      linkedOwnerNames.includes(q) ||
      ownerFullHay.includes(q) ||
      sigHay.includes(q) ||
      attHay.includes(q) ||
      (Array.isArray(b.opsDetails) && b.opsDetails.join(' ').toLowerCase().includes(q));
    const countries = Array.from(selectedCountriesFilter);
    const cities = Array.from(selectedCitiesFilter);
    const types = Array.from(selectedTypesFilter);
    const subTypes = Array.from(selectedSubTypesFilter);
    const areas = Array.from(selectedAreasFilter);
    const opsSel = Array.from(selectedOpStatusFilter);
    const paySel = Array.from(selectedPaymentFinanceFilter);
    const matchCountry = countries.length === 0 || countries.includes(country);
    const matchCity = cities.length === 0 || cities.includes(b.city);
    const matchType = types.length === 0 || types.includes(propertyKind);
    const matchSubType = subTypes.length === 0 || subTypes.includes(propertySubType);
    const matchArea =
      areas.length === 0 ||
      (areas.includes('small') && b.area < 10000) ||
      (areas.includes('medium') && b.area >= 10000 && b.area <= 20000) ||
      (areas.includes('large') && b.area > 20000);
    const bCreated = b.createdAt || b.registeredAt || getRegistrationDateOfBuilding(b, idx);
    const matchCreatedFrom = !propCreatedFrom || bCreated >= propCreatedFrom;
    const matchCreatedTo = !propCreatedTo || bCreated <= propCreatedTo;
    const bOwn = b.ownDate || '';
    const matchOwnFrom = !propOwnFrom || bOwn >= propOwnFrom;
    const matchOwnTo = !propOwnTo || bOwn <= propOwnTo;
    const bBy = String(getEnteredByOfBuilding(b, idx)).toLowerCase();
    const matchEnteredBy = !propEnteredBy || bBy.includes(propEnteredBy);
    const upd = b.updatedAt || '';
    const matchUpdFrom = !propUpdatedFrom || upd >= propUpdatedFrom;
    const matchUpdTo = !propUpdatedTo || upd <= propUpdatedTo;
    const matchOp = opsSel.length === 0 || opsSel.includes(b.operationalStatus);
    const matchPayFinance = paySel.length === 0 || paySel.includes(b.paymentFinanceStatus);
    return matchQ && matchCountry && matchCity && matchType && matchSubType && matchArea &&
      matchCreatedFrom && matchCreatedTo && matchOwnFrom && matchOwnTo && matchEnteredBy &&
      matchUpdFrom && matchUpdTo && matchOp && matchPayFinance;
  });

  syncPropOpMenuMarks();
  syncPropPayFinanceMenuMarks();
  currentPage = 1;
  renderTable();
  renderActiveFilterChips();
  renderSelectionCard(filteredData, 'نتائج التصفية');
}

function setRowsLimit(limit) {
  rowsLimit = limit;
  currentPage = 1;
  renderTable();
}

function handleRowsInput(val) {
  const n = parseInt(val, 10);
  if (!isNaN(n) && n > 0) {
    rowsLimit = n;
  } else {
    rowsLimit = 'all';
  }
  currentPage = 1;
  renderTable();
}

function toggleRowSelection(propNo, checked, inputEl) {
  if (checked) selectedProps.add(propNo);
  else selectedProps.delete(propNo);

  if (inputEl && inputEl.closest) {
    const row = inputEl.closest('tr');
    if (row) {
      row.classList.toggle('selected-row', checked);
    }
  }

  updateSelectionFromChecked();
}

function toggleSelectAll() {
  const total = filteredData.length;
  const perPage = rowsLimit === 'all' ? (total || 1) : rowsLimit;
  const start = rowsLimit === 'all' ? 0 : (currentPage - 1) * perPage;
  const end = rowsLimit === 'all' ? total : start + perPage;
  const visible = filteredData.slice(start, end);
  const allSelected = visible.length > 0 && visible.every(b => selectedProps.has(b.propNo));
  if (allSelected) {
    visible.forEach(b => selectedProps.delete(b.propNo));
  } else {
    visible.forEach(b => selectedProps.add(b.propNo));
  }
  renderTable();
  updateSelectionFromChecked();
}

function toggleMultiSelect() {
  multiSelectEnabled = !multiSelectEnabled;
  const float = document.getElementById('props-cards-float');
  if (!multiSelectEnabled) {
    selectedProps = new Set();
    const selectAll = document.getElementById('select-all');
    if (selectAll) selectAll.checked = false;
    const priceCard = document.getElementById('props-price-card');
    if (priceCard) priceCard.style.display = 'none';
    if (float) float.classList.remove('pinned');
  } else {
    if (float) float.classList.add('pinned');
  }
  const btn = document.getElementById('multi-select-btn');
  if (btn) {
    btn.textContent = multiSelectEnabled ? 'إلغاء الاختيار المتعدد' : 'اختيار متعدد';
  }
  renderTable();
  updateSelectColumnVisibility();
  if (!multiSelectEnabled) {
    renderSelectionCard(filteredData, 'نتائج التصفية');
  }
}

function changePage(delta) {
  const total = filteredData.length;
  const perPage = rowsLimit === 'all' ? (total || 1) : rowsLimit;
  const totalPages = Math.max(1, Math.ceil(total / perPage));
  currentPage = Math.min(totalPages, Math.max(1, currentPage + delta));
  renderTable();
}

function renderSelectionCard(source, modeLabel) {
  const list = (source && source.length) ? source : buildings;
  const totalArea = list.reduce((sum, b) => sum + (b.area || 0), 0);
  const count = list.length;

  const areaEl = document.getElementById('selection-area');
  const countEl = document.getElementById('selection-count');
  const barEl = document.getElementById('selection-bar-fill');
  const modeEl = document.getElementById('selection-mode');
  const shareEl = document.getElementById('selection-share');

  if (!areaEl || !countEl || !barEl || !modeEl || !shareEl) return;

  areaEl.textContent = count ? formatAreaFromM2(totalArea) : '—';
  countEl.textContent = count ? `${count} عقار` : '-- عقار';

  const pct = totalAreaAll ? Math.min(100, Math.round((totalArea / totalAreaAll) * 100)) : 0;
  barEl.style.width = pct + '%';

  modeEl.textContent = modeLabel || 'جميع العقارات';
  shareEl.textContent = pct + '٪ من المساحة الكلية';

  // Update price card if multi-select is enabled and items are selected
  const priceCard = document.getElementById('props-price-card');
  if (priceCard) {
    const isSelection = multiSelectEnabled && selectedProps.size > 0;
    priceCard.style.display = isSelection ? '' : 'none';
    if (isSelection) {
      const fmtPrice = v => isFinite(v) && v > 0
        ? '$\u202F' + Number(v).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 })
        : '—';
      const totalApprox = list.reduce((s, b) => s + (Number(b.approxPriceUsd) || 0), 0);
      const totalActual = list.reduce((s, b) => s + (Number(b.actualPriceUsd != null ? b.actualPriceUsd : b.value) || 0), 0);
      document.getElementById('props-approx-value').textContent = fmtPrice(totalApprox);
      document.getElementById('props-actual-value').textContent = fmtPrice(totalActual);
      document.getElementById('props-price-mode').textContent = `${count} عقار محدد`;
    }
  }
}

function refreshAfterPrefsChange() {
  if (window.__prefsHydrating) return;
  renderFinancialOverviewStats();
  renderLegalOverviewCharts();
  renderLegalRequestedCharts();
  renderGeneralOverviewCharts();
  renderTable();
  const selectedList = buildings.filter(b => selectedProps.has(b.propNo));
  if (selectedList.length) {
    renderSelectionCard(selectedList, 'العقارات المحددة');
  } else {
    renderSelectionCard(filteredData, 'نتائج التصفية');
  }
}

function updateSelectionFromChecked() {
  const selectedList = buildings.filter(b => selectedProps.has(b.propNo));
  if (selectedList.length) {
    renderSelectionCard(selectedList, 'العقارات المحددة');
  } else {
    renderSelectionCard(filteredData, 'نتائج التصفية');
  }
  updateSelectedCount();
}

function areaBandLabel(band) {
  const map = {
    small: 'أقل من ١٠٬٠٠٠ م²',
    medium: '١٠٬٠٠٠ - ٢٠٬٠٠٠ م²',
    large: 'أكثر من ٢٠٬٠٠٠ م²'
  };
  return map[band] || band;
}

function renderActiveFilterChips() {
  const chipsWrap = document.getElementById('filter-chips');
  if (!chipsWrap) return;

  const searchInput = document.getElementById('table-search');
  const searchValue = searchInput ? searchInput.value.trim() : '';
  const activeItems = [];

  if (searchValue) {
    activeItems.push({ type: 'search', value: searchValue, label: `بحث: ${searchValue}` });
  }

  Array.from(selectedCountriesFilter).forEach(country => {
    activeItems.push({ type: 'country', value: country, label: `الدولة: ${country}` });
  });
  Array.from(selectedCitiesFilter).forEach(city => {
    activeItems.push({ type: 'city', value: city, label: `المحافظة: ${city}` });
  });
  Array.from(selectedTypesFilter).forEach(type => {
    activeItems.push({ type: 'type', value: type, label: `العقار: ${type}` });
  });
  Array.from(selectedSubTypesFilter).forEach(sub => {
    activeItems.push({ type: 'subtype', value: sub, label: `النوع: ${sub}` });
  });
  const areas = Array.from(selectedAreasFilter);
  if (areas.length > 0 && areas.length < 3) {
    areas.forEach(band => {
      activeItems.push({ type: 'area', value: band, label: `المساحة: ${areaBandLabel(band)}` });
    });
  }
  if (propCreatedFrom) activeItems.push({ type: 'createdFrom', value: propCreatedFrom, label: `تاريخ الادخال من: ${propCreatedFrom}` });
  if (propCreatedTo)   activeItems.push({ type: 'createdTo',   value: propCreatedTo,   label: `تاريخ الادخال إلى: ${propCreatedTo}` });
  if (propOwnFrom)     activeItems.push({ type: 'ownFrom',     value: propOwnFrom,     label: `تاريخ التملك من: ${propOwnFrom}` });
  if (propOwnTo)       activeItems.push({ type: 'ownTo',       value: propOwnTo,       label: `تاريخ التملك إلى: ${propOwnTo}` });
  if (propEnteredBy)   activeItems.push({ type: 'enteredBy',   value: propEnteredBy,   label: `المدخل: ${propEnteredBy}` });
  if (propUpdatedFrom) activeItems.push({ type: 'updatedFrom', value: propUpdatedFrom, label: `آخر تعديل من: ${propUpdatedFrom}` });
  if (propUpdatedTo)   activeItems.push({ type: 'updatedTo',   value: propUpdatedTo,   label: `آخر تعديل إلى: ${propUpdatedTo}` });
  Array.from(selectedOpStatusFilter).forEach(st => {
    activeItems.push({ type: 'opStatus', value: st, label: `حالة العقار: ${st}` });
  });
  Array.from(selectedPaymentFinanceFilter).forEach(pf => {
    activeItems.push({ type: 'payFinance', value: pf, label: `الدفعات: ${pf}` });
  });

  chipsWrap.innerHTML = '';
  const row = document.createElement('div');
  row.style.display = 'flex';
  row.style.alignItems = 'center';
  row.style.gap = '8px';
  row.style.flexWrap = 'wrap';

  const label = document.createElement('span');
  label.className = 'filter-label';
  label.textContent = 'التصفية الحالية:';
  row.appendChild(label);

  const itemsToRender = activeItems.length
    ? activeItems
    : [{ type: 'all', value: 'all', label: 'الكل' }];

  itemsToRender.forEach(item => {
    const chip = document.createElement('span');
    chip.className = 'chip active';
    chip.style.cursor = 'pointer';
    chip.setAttribute('role', 'button');
    chip.setAttribute('tabindex', '0');
    chip.onclick = () => removeActiveFilter(item.type, item.value);
    chip.onkeydown = e => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        removeActiveFilter(item.type, item.value);
      }
    };
    chip.appendChild(document.createTextNode(`${item.label} `));
    const x = document.createElement('span');
    x.className = 'chip-remove';
    x.textContent = '×';
    chip.appendChild(x);
    row.appendChild(chip);
  });

  chipsWrap.appendChild(row);
}

function removeActiveFilter(type, value) {
  if (type === 'all') {
    selectedCountriesFilter.clear();
    selectedCitiesFilter.clear();
    selectedTypesFilter.clear();
    selectedSubTypesFilter.clear();
    selectedAreasFilter.clear();
    const searchInput = document.getElementById('table-search');
    if (searchInput) searchInput.value = '';
    const cf = document.getElementById('prop-created-from'); if (cf) cf.value = '';
    const ct = document.getElementById('prop-created-to');   if (ct) ct.value = '';
    const of = document.getElementById('prop-own-from');     if (of) of.value = '';
    const ot = document.getElementById('prop-own-to');       if (ot) ot.value = '';
    const eb = document.getElementById('prop-entered-by');   if (eb) eb.value = '';
    const uf = document.getElementById('prop-updated-from'); if (uf) uf.value = '';
    const ut = document.getElementById('prop-updated-to');   if (ut) ut.value = '';
    propCreatedFrom = propCreatedTo = propOwnFrom = propOwnTo = propEnteredBy = '';
    propUpdatedFrom = propUpdatedTo = '';
    selectedOpStatusFilter.clear();
    selectedPaymentFinanceFilter.clear();
    syncPropOpMenuMarks();
    syncPropPayFinanceMenuMarks();
    updateDateRangeLabel('prop-updated-from','prop-updated-to','prop-updated-label','prop-updated-btn');
    syncCascadeToggles();
    updateCascadeLabel();
  } else if (type === 'search') {
    const searchInput = document.getElementById('table-search');
    if (searchInput) searchInput.value = '';
  } else if (type === 'enteredBy') {
    const el = document.getElementById('prop-entered-by'); if (el) el.value = '';
    propEnteredBy = '';
  } else if (type === 'country') {
    selectedCountriesFilter.delete(value);
  } else if (type === 'city') {
    selectedCitiesFilter.delete(value);
  } else if (type === 'type') {
    selectedTypesFilter.delete(value);
    selectedSubTypesFilter.clear();
    syncCascadeToggles();
    updateCascadeLabel();
  } else if (type === 'subtype') {
    selectedSubTypesFilter.delete(value);
    syncCascadeToggles();
    updateCascadeLabel();
  } else if (type === 'area') {
    selectedAreasFilter.delete(value);
  } else if (type === 'createdFrom') {
    const el = document.getElementById('prop-created-from'); if (el) el.value = '';
    propCreatedFrom = '';
    updateDateRangeLabel('prop-created-from','prop-created-to','prop-created-label','prop-created-btn');
  } else if (type === 'createdTo') {
    const el = document.getElementById('prop-created-to'); if (el) el.value = '';
    propCreatedTo = '';
    updateDateRangeLabel('prop-created-from','prop-created-to','prop-created-label','prop-created-btn');
  } else if (type === 'ownFrom') {
    const el = document.getElementById('prop-own-from'); if (el) el.value = '';
    propOwnFrom = '';
    updateDateRangeLabel('prop-own-from','prop-own-to','prop-own-label','prop-own-btn');
  } else if (type === 'ownTo') {
    const el = document.getElementById('prop-own-to'); if (el) el.value = '';
    propOwnTo = '';
    updateDateRangeLabel('prop-own-from','prop-own-to','prop-own-label','prop-own-btn');
  } else if (type === 'updatedFrom') {
    const el = document.getElementById('prop-updated-from'); if (el) el.value = '';
    propUpdatedFrom = '';
    updateDateRangeLabel('prop-updated-from','prop-updated-to','prop-updated-label','prop-updated-btn');
  } else if (type === 'updatedTo') {
    const el = document.getElementById('prop-updated-to'); if (el) el.value = '';
    propUpdatedTo = '';
    updateDateRangeLabel('prop-updated-from','prop-updated-to','prop-updated-label','prop-updated-btn');
  } else if (type === 'opStatus') {
    selectedOpStatusFilter.delete(value);
    syncPropOpMenuMarks();
  } else if (type === 'payFinance') {
    selectedPaymentFinanceFilter.delete(value);
    syncPropPayFinanceMenuMarks();
  }

  updateCountryLabel();
  updateCountryAllToggle();
  renderCityMenu();
  updateCityLabel();
  updateTypeLabel();
  updateTypeAllToggle();
  updateAreaLabel();
  updateAreaAllToggle();
  currentPage = 1;
  filterTable();
}

/* ─── SORT ─── */
let seqSortDir  = 0; // 0 = none, 1 = asc, -1 = desc
let areaSortDir = 0;

function resetSortIcons(except) {
  const seqIcon  = document.getElementById('sort-seq');
  const areaIcon = document.getElementById('sort-area');
  if (seqIcon && except !== 'seq') {
    seqIcon.textContent = '↕';
    seqIcon.classList.remove('active');
  }
  if (areaIcon && except !== 'area') {
    areaIcon.textContent = '↕';
    areaIcon.classList.remove('active');
  }
}

function sortBySeq() {
  // toggle direction (افتراضي: من الأصغر للأكبر في أول ضغطة)
  seqSortDir = seqSortDir === 1 ? -1 : 1;
  areaSortDir = 0;
  resetSortIcons('seq');

  const icon = document.getElementById('sort-seq');
  if (icon) {
    icon.textContent = seqSortDir === 1 ? '↑' : '↓';
    icon.classList.add('active');
  }

  filteredData.sort((a, b) => {
    const av = a.propNo || '';
    const bv = b.propNo || '';
    return av.localeCompare(bv, 'ar') * seqSortDir;
  });

  currentPage = 1;
  renderTable();
}

function sortByArea() {
  // toggle direction (افتراضي: من الأكبر للأصغر في أول ضغطة)
  areaSortDir = areaSortDir === -1 ? 1 : -1;
  seqSortDir = 0;
  resetSortIcons('area');

  const icon = document.getElementById('sort-area');
  if (icon) {
    icon.textContent = areaSortDir === 1 ? '↑' : '↓';
    icon.classList.add('active');
  }

  filteredData.sort((a, b) => {
    const av = a.area || 0;
    const bv = b.area || 0;
    return (av - bv) * areaSortDir;
  });

  currentPage = 1;
  renderTable();
}

/* ─── COLUMN TOGGLE + REORDER ─── */
const colVisible = {
  seq: true,
  propnoMahder: true,
  propOwners: true,
  country: true,
  city: true,
  type: true,
  owndate: true,
  area: true,
  geo: false,
  propNotes: true,
  opstatus: true,
  approxprice: true,
  actualprice: true,
  payfinance: true,
  paydetail: true,
  view: true,
  propEntered: true,
  propCreated: true,
  propUpdated: true
};

let columnOrder = [
  'col-seq',
  'col-propnoMahder',
  'col-propOwners',
  'col-country',
  'col-city',
  'col-type',
  'col-owndate',
  'col-area',
  'col-geo',
  'col-propNotes',
  'col-opstatus',
  'col-approxprice',
  'col-actualprice',
  'col-payfinance',
  'col-paydetail',
  'col-view',
  'col-propEntered',
  'col-propCreated',
  'col-propUpdated'
];
let columnReorderMode = false;
let draggedColumnKey = null;
let propertyToolbarMode = 'search';

function setPropertyToolbarMode(mode) {
  // Toggle: clicking 'reports' while already in reports → close it
  if (mode === 'reports' && propertyToolbarMode === 'reports') mode = 'none';
  // 'close-search' = user pressed ✕ → go back to no active mode
  const validMode = ['search', 'reports'].includes(mode) ? mode : 'none';
  propertyToolbarMode = validMode;

  const searchBtn    = document.getElementById('toolbar-main-search');
  const inlineSearch = document.getElementById('toolbar-inline-search');
  const reportsBtn   = document.getElementById('toolbar-main-reports');

  const isSearch = validMode === 'search';
  if (searchBtn)    searchBtn.style.display    = isSearch ? 'none' : '';
  if (inlineSearch) inlineSearch.classList.toggle('active', isSearch);
  if (reportsBtn) {
    reportsBtn.classList.toggle('active', validMode === 'reports');
    reportsBtn.classList.toggle('active-caret', validMode === 'reports');
  }

  const reportsPanel = document.getElementById('toolbar-reports-panel');
  const chips        = document.getElementById('filter-chips');
  if (reportsPanel) reportsPanel.hidden = validMode !== 'reports';
  if (chips)        chips.hidden        = validMode !== 'reports';

  if (validMode !== 'reports') {
    closeAllMenus('');
    if (columnReorderMode) {
      columnReorderMode = false;
      setupColumnReorderHandlers();
      const btn = document.getElementById('reorder-cols-btn');
      if (btn) btn.textContent = '⇅ إعادة الترتيب';
    }
  }

  if (isSearch) {
    const searchInput = document.getElementById('table-search');
    if (searchInput) searchInput.focus();
  }
}

function closeAllMenus(exceptMenuId) {
  const keepOpenId = exceptMenuId || '';
  document.querySelectorAll('.col-menu.open, .cascade-menu.open, .date-range-popover.open, .export-dropdown-menu.open').forEach(menu => {
    if (menu.id !== keepOpenId) menu.classList.remove('open');
  });
}

/* ── Date-range dropdown helpers ── */
function toggleDateRangePopover(popId, event) {
  if (event) event.stopPropagation();
  const pop = document.getElementById(popId);
  if (!pop) return;
  const isOpen = pop.classList.contains('open');
  // Close all other menus and popovers
  closeAllMenus(isOpen ? '' : popId);
  pop.classList.toggle('open', !isOpen);
}

function updateDateRangeLabel(fromId, toId, labelId, btnId) {
  const fromEl = document.getElementById(fromId);
  const toEl   = document.getElementById(toId);
  const labelEl = document.getElementById(labelId);
  const btnEl   = document.getElementById(btnId);
  if (!fromEl || !toEl || !labelEl) return;
  const from = fromEl.value;
  const to   = toEl.value;
  if (from && to)   labelEl.textContent = `${from} — ${to}`;
  else if (from)    labelEl.textContent = `من ${from}`;
  else if (to)      labelEl.textContent = `إلى ${to}`;
  else              labelEl.textContent = 'من — إلى';
  if (btnEl) btnEl.classList.toggle('has-value', !!(from || to));
}

function clearDateRange(fromId, toId, labelId, btnId) {
  const fromEl = document.getElementById(fromId);
  const toEl   = document.getElementById(toId);
  if (fromEl) fromEl.value = '';
  if (toEl)   toEl.value   = '';
  updateDateRangeLabel(fromId, toId, labelId, btnId);
}

// Close date-range popovers when clicking outside
document.addEventListener('click', e => {
  if (!e.target.closest('.date-range-dropdown')) {
    document.querySelectorAll('.date-range-popover.open').forEach(p => p.classList.remove('open'));
  }
});

// Prevent clicks inside a popover from bubbling to the document close handler
document.addEventListener('click', e => {
  if (e.target.closest('.date-range-popover')) e.stopPropagation();
}, true);

function toggleExportDropdown(menuId) {
  const menu = document.getElementById(menuId);
  if (!menu) return;
  const isOpen = menu.classList.contains('open');
  // close all other export dropdowns
  document.querySelectorAll('.export-dropdown-menu.open').forEach(m => m.classList.remove('open'));
  if (!isOpen) menu.classList.add('open');
}

function closeExportDropdown(menuId) {
  const menu = document.getElementById(menuId);
  if (menu) menu.classList.remove('open');
}

document.addEventListener('click', e => {
  if (!e.target.closest('.export-dropdown')) {
    document.querySelectorAll('.export-dropdown-menu.open').forEach(m => m.classList.remove('open'));
  }
});

function onOwnerCatChange(pageKey) {
  const catEl = document.getElementById(`${pageKey}-owner-cat-filter`);
  const subEl = document.getElementById(`${pageKey}-owner-sub-filter`);
  if (!catEl || !subEl) return;
  const cat = catEl.value;
  const subs = cat ? (propertySubTypes[cat] || []) : [];
  subEl.innerHTML = '<option value="">الكل</option>' +
    subs.map(s => `<option value="${s}">${s}</option>`).join('');
  filterAuxRecords(pageKey);
}

/* ── Cascading type+subtype filter ── */
function toggleCascadeMenu(event) {
  if (event) event.stopPropagation();
  const menu = document.getElementById('cascade-menu');
  if (!menu) return;
  const isOpen = menu.classList.contains('open');
  closeAllMenus(isOpen ? '' : 'cascade-menu');
  menu.classList.toggle('open', !isOpen);
}

function updateCascadeLabel() {
  const btn = document.getElementById('filter-cascade-label');
  if (!btn) return;
  const cats = Array.from(selectedTypesFilter);
  const subs = Array.from(selectedSubTypesFilter);
  if (!cats.length && !subs.length) { btn.textContent = 'نوع العقار'; return; }
  const parts = [];
  if (cats.length) parts.push(cats.join('، '));
  if (subs.length) parts.push(subs.join('، '));
  btn.textContent = parts.join(' / ');
}

function toggleCascadeCat(cat, event) {
  if (event) event.stopPropagation();
  if (selectedTypesFilter.has(cat)) {
    selectedTypesFilter.delete(cat);
    // also remove sub-types belonging to this category
    (propertySubTypes[cat] || []).forEach(s => selectedSubTypesFilter.delete(s));
  } else {
    selectedTypesFilter.add(cat);
  }
  syncCascadeToggles();
  updateCascadeLabel();
  currentPage = 1;
  filterTable();
}

function toggleCascadeSub(sub, event) {
  if (event) event.stopPropagation();
  if (selectedSubTypesFilter.has(sub)) {
    selectedSubTypesFilter.delete(sub);
  } else {
    selectedSubTypesFilter.add(sub);
    // auto-select parent category
    for (const [cat, subs] of Object.entries(propertySubTypes)) {
      if (subs.includes(sub)) selectedTypesFilter.add(cat);
    }
  }
  syncCascadeToggles();
  updateCascadeLabel();
  currentPage = 1;
  filterTable();
}

function toggleAllCascade(event) {
  if (event) event.stopPropagation();
  if (selectedTypesFilter.size > 0 || selectedSubTypesFilter.size > 0) {
    selectedTypesFilter.clear();
    selectedSubTypesFilter.clear();
  }
  syncCascadeToggles();
  updateCascadeLabel();
  currentPage = 1;
  filterTable();
}

function syncCascadeToggles() {
  // all toggle
  const allTog = document.getElementById('cascade-all');
  if (allTog) allTog.textContent = (selectedTypesFilter.size === 0 && selectedSubTypesFilter.size === 0) ? '✓' : '';
  // category toggles
  ['أرض','سكن','تجاري'].forEach(cat => {
    const el = document.getElementById(`cascade-cat-${cat}`);
    if (el) el.textContent = selectedTypesFilter.has(cat) ? '✓' : '';
  });
  // sub-type toggles
  Object.values(propertySubTypes).flat().forEach(sub => {
    const el = document.getElementById(`cascade-sub-${sub}`);
    if (el) el.textContent = selectedSubTypesFilter.has(sub) ? '✓' : '';
  });
}

// Close cascade menu when clicking outside
document.addEventListener('click', e => {
  if (!e.target.closest('#cascade-menu') && !e.target.closest('#filter-cascade-label')) {
    const menu = document.getElementById('cascade-menu');
    if (menu) menu.classList.remove('open');
  }
  // Also close owner cascade menus
  if (!e.target.closest('.cascade-menu') && !e.target.closest('[id$="-cascade-btn"]')) {
    document.querySelectorAll('[id$="-cascade-menu"]').forEach(m => {
      if (m.id !== 'cascade-menu') m.classList.remove('open');
    });
  }
  const csm = document.getElementById('consult-sigtype-menu');
  if (csm && !e.target.closest('#consult-sigtype-menu') && !e.target.closest('#consult-sigtype-btn')) {
    csm.classList.remove('open');
  }
  const pom = document.getElementById('prop-op-menu');
  if (pom && !e.target.closest('#prop-op-menu') && !e.target.closest('#filter-prop-op-btn')) pom.classList.remove('open');
  const ppm = document.getElementById('prop-pay-menu');
  if (ppm && !e.target.closest('#prop-pay-menu') && !e.target.closest('#filter-prop-pay-btn')) ppm.classList.remove('open');
});

/* ── Owner cascade filter state (per pageKey) ── */
const ownerCascadeCats = {};  // pageKey → Set of selected categories
const ownerCascadeSubs = {};  // pageKey → Set of selected sub-types

function getOwnerCascadeState(pageKey) {
  if (!ownerCascadeCats[pageKey]) ownerCascadeCats[pageKey] = new Set();
  if (!ownerCascadeSubs[pageKey]) ownerCascadeSubs[pageKey] = new Set();
  return { cats: ownerCascadeCats[pageKey], subs: ownerCascadeSubs[pageKey] };
}

function toggleOwnerCascadeMenu(event, pageKey) {
  if (event) event.stopPropagation();
  const menu = document.getElementById(`${pageKey}-cascade-menu`);
  if (!menu) return;
  const isOpen = menu.classList.contains('open');
  closeAllMenus(isOpen ? '' : `${pageKey}-cascade-menu`);
  menu.classList.toggle('open', !isOpen);
}

function syncOwnerCascadeToggles(pageKey) {
  const { cats, subs } = getOwnerCascadeState(pageKey);
  const allTog = document.getElementById(`${pageKey}-cascade-all`);
  if (allTog) allTog.textContent = (cats.size === 0 && subs.size === 0) ? '✓' : '';
  ['أرض','سكن','تجاري'].forEach(cat => {
    const el = document.getElementById(`${pageKey}-cascade-cat-${cat}`);
    if (el) el.textContent = cats.has(cat) ? '✓' : '';
  });
  Object.values(propertySubTypes).flat().forEach(sub => {
    const el = document.getElementById(`${pageKey}-cascade-sub-${sub}`);
    if (el) el.textContent = subs.has(sub) ? '✓' : '';
  });
}

function updateOwnerCascadeLabel(pageKey) {
  const btn = document.getElementById(`${pageKey}-cascade-btn`);
  if (!btn) return;
  const { cats, subs } = getOwnerCascadeState(pageKey);
  if (!cats.size && !subs.size) { btn.textContent = 'نوع العقار'; return; }
  const parts = [];
  if (cats.size) parts.push(Array.from(cats).join('، '));
  if (subs.size) parts.push(Array.from(subs).join('، '));
  btn.textContent = parts.join(' / ');
}

function toggleOwnerCascadeCat(cat, pageKey, event) {
  if (event) event.stopPropagation();
  const { cats, subs } = getOwnerCascadeState(pageKey);
  if (cats.has(cat)) {
    cats.delete(cat);
    (propertySubTypes[cat] || []).forEach(s => subs.delete(s));
  } else {
    cats.add(cat);
  }
  syncOwnerCascadeToggles(pageKey);
  updateOwnerCascadeLabel(pageKey);
  filterAuxRecords(pageKey);
}

function toggleOwnerCascadeSub(sub, pageKey, event) {
  if (event) event.stopPropagation();
  const { cats, subs } = getOwnerCascadeState(pageKey);
  if (subs.has(sub)) {
    subs.delete(sub);
  } else {
    subs.add(sub);
    for (const [cat, subList] of Object.entries(propertySubTypes)) {
      if (subList.includes(sub)) cats.add(cat);
    }
  }
  syncOwnerCascadeToggles(pageKey);
  updateOwnerCascadeLabel(pageKey);
  filterAuxRecords(pageKey);
}

function toggleAllOwnerCascade(event, pageKey) {
  if (event) event.stopPropagation();
  const { cats, subs } = getOwnerCascadeState(pageKey);
  cats.clear(); subs.clear();
  syncOwnerCascadeToggles(pageKey);
  updateOwnerCascadeLabel(pageKey);
  filterAuxRecords(pageKey);
}

function onPropDateFilter() {
  filterTable();
}

/* ── Toggle-all helpers for filter dropdowns ── */
const ALL_COUNTRIES = ['سورية', 'الامارات', 'أخرى'];
const ALL_TYPES     = ['أرض', 'سكن', 'تجاري'];
const ALL_AREAS     = ['small', 'medium', 'large'];

function updateCountryAllToggle() {
  const el = document.getElementById('country-all');
  if (!el) return;
  el.textContent = selectedCountriesFilter.size === 0 ? '✓' : '';
}

function toggleAllCountries() {
  if (selectedCountriesFilter.size > 0) {
    selectedCountriesFilter.clear();
  }
  updateCountryLabel();
  updateCountryAllToggle();
  ALL_COUNTRIES.forEach(c => {
    const idMap = { 'سورية': 'country-syria', 'الامارات': 'country-uae', 'أخرى': 'country-other' };
    const el = document.getElementById(idMap[c]);
    if (el) el.textContent = '';
  });
  renderCityMenu();
  updateCityLabel();
  currentPage = 1;
  filterTable();
}

function updateTypeAllToggle() {
  const el = document.getElementById('type-all');
  if (!el) return;
  el.textContent = selectedTypesFilter.size === 0 ? '✓' : '';
}

function toggleAllTypes() {
  if (selectedTypesFilter.size > 0) {
    selectedTypesFilter.clear();
    selectedSubTypesFilter.clear();
    const idMap = { 'أرض': 'type-land', 'سكن': 'type-house', 'تجاري': 'type-villa' };
    ALL_TYPES.forEach(t => { const el = document.getElementById(idMap[t]); if (el) el.textContent = ''; });
  }
  updateTypeAllToggle();
  updateTypeLabel();
  renderSubTypeMenu();
  updateSubTypeLabel();
  currentPage = 1;
  filterTable();
}

/* ── Sub-type filter ── */
function renderSubTypeMenu() {
  const menu = document.getElementById('subtype-menu');
  if (!menu) return;
  // Which categories are selected? If none → show all sub-types
  const selected = Array.from(selectedTypesFilter);
  const cats = selected.length ? selected : ALL_TYPES;
  const subs = new Set();
  cats.forEach(cat => (propertySubTypes[cat] || []).forEach(s => subs.add(s)));
  // Remove selected sub-types that no longer belong to current categories
  Array.from(selectedSubTypesFilter).forEach(s => { if (!subs.has(s)) selectedSubTypesFilter.delete(s); });
  const subList = Array.from(subs);
  menu.innerHTML = subList.length
    ? `<div class="col-menu-item col-menu-selectall" onclick="toggleAllSubTypes()"><div class="col-toggle" id="subtype-all">${selectedSubTypesFilter.size === 0 ? '✓' : ''}</div> تحديد الكل</div>` +
      subList.map(s => `<div class="col-menu-item" onclick="toggleSubTypeFilter('${s}')"><div class="col-toggle" id="subtype-${s}">${selectedSubTypesFilter.has(s) ? '✓' : ''}</div> ${s}</div>`).join('')
    : '<div class="col-menu-item" style="color:var(--text-muted)">اختر فئة أولاً</div>';
}

function updateSubTypeLabel() {
  const el = document.getElementById('filter-subtype-label');
  if (!el) return;
  const subs = Array.from(selectedSubTypesFilter);
  el.textContent = subs.length === 0 ? 'نوع العقار' : subs.length === 1 ? subs[0] : `أنواع متعددة (${subs.length})`;
}

function toggleSubTypeMenu() {
  const menu = document.getElementById('subtype-menu');
  if (!menu) return;
  renderSubTypeMenu();
  const shouldOpen = !menu.classList.contains('open');
  closeAllMenus(shouldOpen ? 'subtype-menu' : '');
  menu.classList.toggle('open', shouldOpen);
}

function toggleSubTypeFilter(sub) {
  if (selectedSubTypesFilter.has(sub)) selectedSubTypesFilter.delete(sub);
  else selectedSubTypesFilter.add(sub);
  const el = document.getElementById(`subtype-${sub}`);
  if (el) el.textContent = selectedSubTypesFilter.has(sub) ? '✓' : '';
  const allTog = document.getElementById('subtype-all');
  if (allTog) allTog.textContent = selectedSubTypesFilter.size === 0 ? '✓' : '';
  updateSubTypeLabel();
  currentPage = 1;
  filterTable();
}

function toggleAllSubTypes() {
  if (selectedSubTypesFilter.size > 0) {
    selectedSubTypesFilter.clear();
    document.querySelectorAll('[id^="subtype-"]:not(#subtype-all):not(#filter-subtype-label)').forEach(el => { el.textContent = ''; });
  }
  const allTog = document.getElementById('subtype-all');
  if (allTog) allTog.textContent = '✓';
  updateSubTypeLabel();
  currentPage = 1;
  filterTable();
}

function updateAreaAllToggle() {
  const el = document.getElementById('area-all');
  if (!el) return;
  el.textContent = (selectedAreasFilter.size === 0 || selectedAreasFilter.size === 3) ? '✓' : '';
}

function toggleAllAreas() {
  if (selectedAreasFilter.size > 0 && selectedAreasFilter.size < 3) {
    // deselect all
    selectedAreasFilter.clear();
    ['area-small', 'area-medium', 'area-large'].forEach(id => {
      const el = document.getElementById(id); if (el) el.textContent = '';
    });
  } else if (selectedAreasFilter.size === 0) {
    // select all
    ALL_AREAS.forEach(b => selectedAreasFilter.add(b));
    ['area-small', 'area-medium', 'area-large'].forEach(id => {
      const el = document.getElementById(id); if (el) el.textContent = '✓';
    });
  } else {
    // all 3 selected → clear all
    selectedAreasFilter.clear();
    ['area-small', 'area-medium', 'area-large'].forEach(id => {
      const el = document.getElementById(id); if (el) el.textContent = '';
    });
  }
  updateAreaAllToggle();
  updateAreaLabel();
  currentPage = 1;
  filterTable();
}

function toggleColMenu(event) {
  if (event) event.stopPropagation();
  const menu = document.getElementById('col-menu');
  if (!menu) return;
  const shouldOpen = !menu.classList.contains('open');
  closeAllMenus(shouldOpen ? 'col-menu' : '');
  menu.classList.toggle('open', shouldOpen);
}

document.addEventListener('click', e => {
  const inMainColMenu = !!e.target.closest('#col-menu');
  const onMainColMenuBtn = !!e.target.closest('#prop-col-menu-btn');
  const inAuxColMenu = !!e.target.closest('.col-menu[data-aux-menu="1"]');
  const onAuxColMenuBtn = !!e.target.closest('[onclick*="toggleAuxColMenu"]');
  const inExportDropdown = !!e.target.closest('.export-dropdown');
  const inFilterDropdown = !!e.target.closest('.filter-dropdown');
  const inCascadeMenu = !!e.target.closest('#cascade-menu');
  const onCascadeBtn = !!e.target.closest('#filter-cascade-label');
  if (!inMainColMenu && !onMainColMenuBtn && !inAuxColMenu && !onAuxColMenuBtn && !inExportDropdown && !inFilterDropdown && !inCascadeMenu && !onCascadeBtn) {
    closeAllMenus('');
  }
});

function renderCityMenu() {
  const menu = document.getElementById('city-menu');
  if (!menu) return;
  const countries = Array.from(selectedCountriesFilter);
  const activeCountries = countries.length ? countries : Object.keys(countryGovernorates);
  const citySet = new Set();
  activeCountries.forEach(country => {
    (countryGovernorates[country] || []).forEach(city => citySet.add(city));
  });
  const cityList = Array.from(citySet);
  selectedCitiesFilter.forEach(city => {
    if (!citySet.has(city)) selectedCitiesFilter.delete(city);
  });
  menu.innerHTML = cityList.length
    ? `<div class="col-menu-item col-menu-selectall" onclick="toggleAllCities()"><div class="col-toggle" id="city-all">${selectedCitiesFilter.size === 0 ? '✓' : ''}</div> تحديد الكل</div>` +
      cityList.map(city => `
      <div class="col-menu-item" onclick="toggleCityFilter('${city}')">
        <div class="col-toggle">${selectedCitiesFilter.has(city) ? '✓' : ''}</div> ${city}
      </div>
    `).join('')
    : '<div class="col-menu-item"><div class="col-toggle"></div> لا توجد محافظات مطابقة</div>';
}

function toggleAllCities() {
  if (selectedCitiesFilter.size > 0) {
    selectedCitiesFilter.clear();
  }
  updateCityLabel();
  renderCityMenu();
  currentPage = 1;
  filterTable();
}

function updateCountryLabel() {
  const labelEl = document.getElementById('filter-country-label');
  if (!labelEl) return;
  const countries = Array.from(selectedCountriesFilter);
  if (countries.length === 0) {
    labelEl.textContent = 'الدول';
  } else if (countries.length === 1) {
    labelEl.textContent = countries[0];
  } else {
    labelEl.textContent = `دول متعددة (${countries.length})`;
  }
  const idMap = { 'سورية': 'country-syria', 'الامارات': 'country-uae', 'أخرى': 'country-other' };
  Object.keys(idMap).forEach(country => {
    const el = document.getElementById(idMap[country]);
    if (el) el.textContent = selectedCountriesFilter.has(country) ? '✓' : '';
  });
}

function toggleCountryMenu() {
  const menu = document.getElementById('country-menu');
  if (!menu) return;
  const shouldOpen = !menu.classList.contains('open');
  closeAllMenus(shouldOpen ? 'country-menu' : '');
  menu.classList.toggle('open', shouldOpen);
}

function toggleCountryFilter(country) {
  if (selectedCountriesFilter.has(country)) {
    selectedCountriesFilter.delete(country);
  } else {
    selectedCountriesFilter.add(country);
  }
  updateCountryLabel();
  updateCountryAllToggle();
  renderCityMenu();
  updateCityLabel();
  currentPage = 1;
  filterTable();
}

function toggleCol(cls) {
  const key = cls.replace('col-','');
  if (!(key in colVisible)) return;
  colVisible[key] = !colVisible[key];
  applyColumnVisibility();
  // sync the select-all toggle
  const allVisible = Object.values(colVisible).every(v => v);
  const allTog = document.getElementById('tog-all');
  if (allTog) allTog.textContent = allVisible ? '✓' : '';
}

function toggleAllColumns() {
  const allVisible = Object.values(colVisible).every(v => v);
  const newVal = !allVisible;
  Object.keys(colVisible).forEach(key => { colVisible[key] = newVal; });
  applyColumnVisibility();
  const allTog = document.getElementById('tog-all');
  if (allTog) allTog.textContent = newVal ? '✓' : '';
}

function applyColumnVisibility() {
  const cg = document.getElementById('main-colgroup');
  Object.keys(colVisible).forEach(key => {
    const cls = 'col-' + key;
    const isVisible = !!colVisible[key];
    document.querySelectorAll('.' + cls).forEach(el => {
      el.style.display = isVisible ? '' : 'none';
    });
    if (cg) {
      const col = cg.querySelector('.' + cls);
      if (col) col.style.display = isVisible ? '' : 'none';
    }
    const mark = document.getElementById('tog-' + key);
    if (mark) mark.textContent = isVisible ? '✓' : '';
  });
  syncMainIdOnlyCompactLayout();
  requestAnimationFrame(() => updateTableScrollStartButtons());
  requestAnimationFrame(() => applyColumnPinning('main-table'));
}

function syncMainIdOnlyCompactLayout() {
  const table = document.getElementById('main-table');
  if (!table) return;
  const visibleKeys = Object.keys(colVisible).filter(key => !!colVisible[key]);
  const idOnlyVisible = visibleKeys.length === 1 && visibleKeys[0] === 'seq';
  table.classList.toggle('id-only-compact', idOnlyVisible);
}

function applyColumnOrder() {
  const table = document.getElementById('main-table');
  if (!table) return;
  const rows = table.querySelectorAll('thead tr, tbody tr:not(.detail-row):not(.ops-row)');
  rows.forEach(row => {
    const selectCell = row.querySelector('.select-col');
    const cellsByKey = new Map();
    columnOrder.forEach(cls => {
      const cell = row.querySelector('.' + cls);
      if (cell) cellsByKey.set(cls, cell);
    });
    if (selectCell) row.appendChild(selectCell);
    columnOrder.forEach(cls => {
      const cell = cellsByKey.get(cls);
      if (cell) row.appendChild(cell);
    });
  });
  const cg = document.getElementById('main-colgroup');
  if (cg) {
    const selectCol = cg.querySelector('.select-col');
    const colsByKey = new Map();
    columnOrder.forEach(cls => {
      const col = cg.querySelector('.' + cls);
      if (col) colsByKey.set(cls, col);
    });
    if (selectCol) cg.appendChild(selectCol);
    columnOrder.forEach(cls => {
      const col = colsByKey.get(cls);
      if (col) cg.appendChild(col);
    });
  }
}

function setupColumnReorderHandlers() {
  const headers = Array.from(document.querySelectorAll('#main-table thead th[data-col-key]'));
  headers.forEach(th => {
    const key = th.dataset.colKey;
    if (!key) return;
    th.draggable = columnReorderMode;
    th.classList.toggle('col-drag', columnReorderMode);
    if (th.dataset.dndBound === '1') return;
    th.dataset.dndBound = '1';
    th.addEventListener('dragstart', e => {
      if (!columnReorderMode) return;
      draggedColumnKey = key;
      e.dataTransfer.effectAllowed = 'move';
      e.dataTransfer.setData('text/plain', key);
    });
    th.addEventListener('dragover', e => {
      if (!columnReorderMode) return;
      e.preventDefault();
      e.dataTransfer.dropEffect = 'move';
    });
    th.addEventListener('drop', e => {
      if (!columnReorderMode) return;
      e.preventDefault();
      const targetKey = key;
      const sourceKey = draggedColumnKey || e.dataTransfer.getData('text/plain');
      if (!sourceKey || !targetKey || sourceKey === targetKey) return;
      const from = columnOrder.indexOf(sourceKey);
      const to = columnOrder.indexOf(targetKey);
      if (from === -1 || to === -1) return;
      const [moved] = columnOrder.splice(from, 1);
      columnOrder.splice(to, 0, moved);
      renderTable();
    });
    th.addEventListener('dragend', () => {
      draggedColumnKey = null;
    });
  });
}

const LOCKED_ID_COLUMN_KEYS = new Set(['col-seq', 'col-ownerId', 'col-signalId', 'col-attachmentId']);
function isLockedIdColumnKey(key) {
  return LOCKED_ID_COLUMN_KEYS.has(key || '');
}

/* ══════════════════════════════════════════════════════════════
   COLUMN PINNING SYSTEM  — Excel-style frozen columns (RTL)
   Columns pin to the RIGHT (visual start in RTL).
   Usage: click the 📌 icon that appears when hovering a column header.
══════════════════════════════════════════════════════════════ */

/** tableId → ordered array of colKeys currently pinned, e.g. ['col-seq','col-propOwners'] */
const _pinnedColsMap = {};

const _COL_PIN_SVG = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
  <line x1="12" y1="17" x2="12" y2="22"/>
  <path d="M5 17h14v-1.76a2 2 0 0 0-1.11-1.79l-1.78-.9A2 2 0 0 1 15 10.76V6h1a2 2 0 0 0 0-4H8a2 2 0 0 0 0 4h1v4.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24Z"/>
</svg>`;

/**
 * Inject pin-icon buttons into all .big-table th[data-col-key] inside scopeEl.
 * Idempotent — skips headers that already have a button.
 * @param {Element|Document} [scopeEl]
 */
function injectPinButtons(scopeEl) {
  const scope = scopeEl || document;
  scope.querySelectorAll('.big-table thead th[data-col-key]').forEach(th => {
    if (th.querySelector('.col-pin-btn')) return;
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'col-pin-btn';
    btn.setAttribute('aria-label', 'تثبيت العمود');
    btn.title = 'تثبيت العمود';
    btn.innerHTML = _COL_PIN_SVG;
    btn.addEventListener('click', e => {
      e.stopPropagation();
      const tableEl = th.closest('.big-table');
      if (!tableEl) return;
      togglePinColumn(tableEl.id, th.dataset.colKey);
    });
    const inner = th.querySelector('.th-inner');
    if (inner) inner.appendChild(btn);
  });
}

/**
 * Toggle a column's pin state for a table.
 * @param {string} tableId  e.g. 'main-table' | 'owners-table'
 * @param {string} colKey   e.g. 'col-seq' | 'col-propOwners'
 */
function togglePinColumn(tableId, colKey) {
  if (!_pinnedColsMap[tableId]) _pinnedColsMap[tableId] = [];
  const arr = _pinnedColsMap[tableId];
  const idx = arr.indexOf(colKey);
  if (idx === -1) arr.push(colKey);
  else arr.splice(idx, 1);
  applyColumnPinning(tableId);
  _syncPinMenuBar(tableId);
}

/**
 * Unpin all columns for a table (called from "إلغاء تثبيت الكل" buttons).
 * @param {string} tableId
 */
function unpinAllColumns(tableId) {
  _pinnedColsMap[tableId] = [];
  applyColumnPinning(tableId);
  _syncPinMenuBar(tableId);
}

/**
 * Apply the current pinning state to the live DOM table.
 * Calculates sticky `right` offsets from actual rendered widths.
 * @param {string} tableId
 */
function applyColumnPinning(tableId) {
  const table = document.getElementById(tableId);
  if (!table) return;
  const pinned = _pinnedColsMap[tableId] || [];

  /* ── Clear previous pinning ─────────────────────────────── */
  table.classList.remove('has-pinned-cols');
  table.querySelectorAll('.col-pinned, .col-pin-edge').forEach(el => {
    el.classList.remove('col-pinned', 'col-pin-edge');
    el.style.removeProperty('right');
  });
  /* Reset select-col sticky state */
  table.querySelectorAll('th.select-col, td.select-col').forEach(el => {
    el.style.removeProperty('position');
    el.style.removeProperty('right');
    el.style.removeProperty('z-index');
  });
  /* Reset all pin buttons */
  table.querySelectorAll('.col-pin-btn').forEach(btn => {
    btn.classList.remove('active');
    btn.title = 'تثبيت العمود';
    btn.setAttribute('aria-pressed', 'false');
  });

  if (pinned.length === 0) return;

  /* ── Measure widths ─────────────────────────────────────── */
  /* select-col is always the base anchor at right:0 */
  const selectTh = table.querySelector('thead th.select-col');
  const selectColW = selectTh ? selectTh.offsetWidth : 44;

  table.classList.add('has-pinned-cols');

  /* Freeze select-col at right: 0 */
  table.querySelectorAll('th.select-col, td.select-col').forEach(el => {
    el.style.right = '0px';
  });

  /* ── Apply sticky right to each pinned column ───────────── */
  /* In RTL the first pinned col is directly adjacent to select-col (at right: selectColW).
     Each subsequent pinned col is further to the left (larger right value). */
  let offset = selectColW;
  pinned.forEach((colKey, i) => {
    const th = table.querySelector(`thead th.${colKey}`);
    const colW = th ? th.offsetWidth : 120;

    table.querySelectorAll(`th.${colKey}, td.${colKey}`).forEach(el => {
      el.classList.add('col-pinned');
      el.style.right = offset + 'px';
    });

    /* Activate pin button */
    if (th) {
      const btn = th.querySelector('.col-pin-btn');
      if (btn) {
        btn.classList.add('active');
        btn.title = 'إلغاء التثبيت';
        btn.setAttribute('aria-pressed', 'true');
      }
    }
    offset += colW;
  });

  /* ── Shadow on outermost (leftmost in RTL) pinned col ────── */
  const lastKey = pinned[pinned.length - 1];
  table.querySelectorAll(`th.${lastKey}, td.${lastKey}`).forEach(el => {
    el.classList.add('col-pin-edge');
  });
}

/**
 * Sync the "Unpin All" bar visibility and count in the col-menu.
 * @param {string} tableId
 */
function _syncPinMenuBar(tableId) {
  const pinned = _pinnedColsMap[tableId] || [];
  const count = pinned.length;
  /* Derive the bar IDs from the tableId */
  const barId   = tableId === 'main-table' ? 'main-pin-actions' : `${tableId.replace('-table','')}-pin-actions`;
  const countId = tableId === 'main-table' ? 'main-pin-count'   : `${tableId.replace('-table','')}-pin-count`;
  const bar = document.getElementById(barId);
  const cnt = document.getElementById(countId);
  if (bar) bar.classList.toggle('visible', count > 0);
  if (cnt) cnt.textContent = count > 0 ? `${count} مثبت` : '';
}

/* ── Bootstrap: inject pin buttons on main table after DOM ready ── */
document.addEventListener('DOMContentLoaded', () => {
  setTimeout(() => injectPinButtons(document), 600);
});

function ensureColumnResizers(tableId, colgroupId) {
  const table = document.getElementById(tableId);
  const colgroup = document.getElementById(colgroupId);
  if (!table || !colgroup) return;
  const headers = table.querySelectorAll('thead th[data-col-key]');
  headers.forEach(th => {
    if (isLockedIdColumnKey(th.dataset.colKey)) {
      const existingHandle = th.querySelector('.col-resize-handle');
      if (existingHandle) existingHandle.remove();
      return;
    }
    if (th.querySelector('.col-resize-handle')) return;
    const handle = document.createElement('span');
    handle.className = 'col-resize-handle';
    handle.setAttribute('aria-hidden', 'true');
    th.appendChild(handle);
  });
}

function bindColumnResizeHandlers(tableId, colgroupId) {
  const table = document.getElementById(tableId);
  const colgroup = document.getElementById(colgroupId);
  if (!table || !colgroup) return;
  const handles = table.querySelectorAll('thead th[data-col-key] .col-resize-handle');
  handles.forEach(handle => {
    if (handle.dataset.resizeBound === '1') return;
    handle.dataset.resizeBound = '1';
    handle.addEventListener('click', e => {
      e.preventDefault();
      e.stopPropagation();
    });
    handle.addEventListener('pointerdown', e => {
      e.preventDefault();
      e.stopPropagation();
      const th = handle.closest('th[data-col-key]');
      if (!th) return;
      const key = th.dataset.colKey;
      if (isLockedIdColumnKey(key)) return;
      const col = colgroup.querySelector(`col.${key}`);
      if (!col) return;
      const startX = e.clientX;
      const startWidth = Math.max(th.getBoundingClientRect().width, 72);
      const minWidth = 72;
      let moved = false;
      document.body.classList.add('is-col-resizing');
      if (handle.setPointerCapture) {
        try { handle.setPointerCapture(e.pointerId); } catch (_) {}
      }
      const onMove = ev => {
        const delta = ev.clientX - startX;
        if (!moved && Math.abs(delta) > 2) moved = true;
        const nextWidth = Math.max(minWidth, startWidth + delta);
        col.style.width = `${nextWidth}px`;
      };
      const onUp = () => {
        window.removeEventListener('pointermove', onMove);
        window.removeEventListener('pointerup', onUp);
        window.removeEventListener('pointercancel', onUp);
        document.body.classList.remove('is-col-resizing');
        if (moved) th.dataset.recentlyResized = String(Date.now());
      };
      window.addEventListener('pointermove', onMove);
      window.addEventListener('pointerup', onUp);
      window.addEventListener('pointercancel', onUp);
    });
  });
  if (table.dataset.resizeClickGuardBound !== '1') {
    table.dataset.resizeClickGuardBound = '1';
    table.addEventListener('click', e => {
      const th = e.target && e.target.closest ? e.target.closest('th[data-col-key]') : null;
      if (!th) return;
      const ts = Number(th.dataset.recentlyResized || 0);
      if (!ts) return;
      if (Date.now() - ts < 250) {
        e.preventDefault();
        e.stopPropagation();
      }
    }, true);
  }
}

function toggleColumnReorderMode() {
  columnReorderMode = !columnReorderMode;
  setupColumnReorderHandlers();
  const btn = document.getElementById('reorder-cols-btn');
  if (btn) btn.textContent = columnReorderMode ? '✓ وضع إعادة الترتيب' : '⇅ إعادة الترتيب';
  if (columnReorderMode) {
    alert('وضع إعادة الترتيب مُفعّل: اسحب عنوان العمود وأفلته في المكان المطلوب.');
  }
}

function toggleCityMenu() {
  const menu = document.getElementById('city-menu');
  if (!menu) return;
  renderCityMenu();
  const shouldOpen = !menu.classList.contains('open');
  closeAllMenus(shouldOpen ? 'city-menu' : '');
  menu.classList.toggle('open', shouldOpen);
}

function updateCityLabel() {
  const labelEl = document.getElementById('filter-city-label');
  if (!labelEl) return;
  const cities = Array.from(selectedCitiesFilter);
  if (cities.length === 0) {
    labelEl.textContent = 'المحافظة';
  } else if (cities.length === 1) {
    labelEl.textContent = cities[0];
  } else {
    labelEl.textContent = `محافظات متعددة (${cities.length})`;
  }
}

function toggleCityFilter(city) {
  if (selectedCitiesFilter.has(city)) {
    selectedCitiesFilter.delete(city);
  } else {
    selectedCitiesFilter.add(city);
  }
  // update city-all toggle
  const allTog = document.getElementById('city-all');
  if (allTog) allTog.textContent = selectedCitiesFilter.size === 0 ? '✓' : '';
  updateCityLabel();
  currentPage = 1;
  filterTable();
}

function toggleTypeMenu() {
  const menu = document.getElementById('type-menu');
  if (!menu) return;
  const shouldOpen = !menu.classList.contains('open');
  closeAllMenus(shouldOpen ? 'type-menu' : '');
  menu.classList.toggle('open', shouldOpen);
}

function updateTypeLabel() {
  const labelEl = document.getElementById('filter-type-label');
  if (!labelEl) return;
  const types = Array.from(selectedTypesFilter);
  if (types.length === 0) {
    labelEl.textContent = 'العقارات';
  } else if (types.length === 1) {
    labelEl.textContent = types[0];
  } else {
    labelEl.textContent = `أنواع متعددة (${types.length})`;
  }
}

function toggleTypeFilter(type) {
  if (selectedTypesFilter.has(type)) {
    selectedTypesFilter.delete(type);
  } else {
    selectedTypesFilter.add(type);
  }
  const idMap = { 'أرض': 'type-land', 'سكن': 'type-house', 'تجاري': 'type-villa' };
  const toggleId = idMap[type];
  if (toggleId) {
    const el = document.getElementById(toggleId);
    if (el) el.textContent = selectedTypesFilter.has(type) ? '✓' : '';
  }
  updateTypeAllToggle();
  updateTypeLabel();
  // Refresh sub-type menu when category changes
  selectedSubTypesFilter.clear();
  renderSubTypeMenu();
  updateSubTypeLabel();
  currentPage = 1;
  filterTable();
}

function toggleAreaMenu() {
  const menu = document.getElementById('area-menu');
  if (!menu) return;
  const shouldOpen = !menu.classList.contains('open');
  closeAllMenus(shouldOpen ? 'area-menu' : '');
  menu.classList.toggle('open', shouldOpen);
}

function updateAreaLabel() {
  const labelEl = document.getElementById('filter-area-label');
  if (!labelEl) return;
  const areas = Array.from(selectedAreasFilter);
  if (areas.length === 0 || areas.length === 3) {
    labelEl.textContent = 'المساحات';
  } else if (areas.length === 1) {
    const m = { small: 'أقل من ١٠٬٠٠٠ م²', medium: '١٠٬٠٠٠ - ٢٠٬٠٠٠ م²', large: 'أكثر من ٢٠٬٠٠٠ م²' };
    labelEl.textContent = m[areas[0]] || 'مساحة واحدة';
  } else {
    labelEl.textContent = `فئات مساحات متعددة (${areas.length})`;
  }
}

function toggleAreaFilter(band) {
  if (selectedAreasFilter.has(band)) {
    selectedAreasFilter.delete(band);
  } else {
    selectedAreasFilter.add(band);
  }
  const toggleId = band === 'small' ? 'area-small' : band === 'medium' ? 'area-medium' : 'area-large';
  const el = document.getElementById(toggleId);
  if (el) el.textContent = selectedAreasFilter.has(band) ? '✓' : '';
  updateAreaAllToggle();
  updateAreaLabel();
  currentPage = 1;
  filterTable();
}

function togglePropOpMenu() {
  const menu = document.getElementById('prop-op-menu');
  if (!menu) return;
  const shouldOpen = !menu.classList.contains('open');
  closeAllMenus(shouldOpen ? 'prop-op-menu' : '');
  menu.classList.toggle('open', shouldOpen);
}

function syncPropOpMenuMarks() {
  const all = document.getElementById('prop-op-all');
  if (all) all.textContent = selectedOpStatusFilter.size === 0 ? '✓' : '';
  const pairs = [['يعمل', 'prop-op-working'], ['جاري صيانته', 'prop-op-maint'], ['متوقف عن العمل', 'prop-op-stopped']];
  pairs.forEach(([s, id]) => {
    const el = document.getElementById(id);
    if (el) el.textContent = selectedOpStatusFilter.has(s) ? '✓' : '';
  });
  const btn = document.getElementById('filter-prop-op-btn');
  if (btn) btn.textContent = selectedOpStatusFilter.size ? `حالة (${selectedOpStatusFilter.size})` : 'حالة العقار';
}

function togglePropOpStatusFilter(statusLabel) {
  if (selectedOpStatusFilter.has(statusLabel)) selectedOpStatusFilter.delete(statusLabel);
  else selectedOpStatusFilter.add(statusLabel);
  syncPropOpMenuMarks();
  currentPage = 1;
  filterTable();
}

function toggleAllPropOpStatus() {
  selectedOpStatusFilter.clear();
  syncPropOpMenuMarks();
  currentPage = 1;
  filterTable();
}

function togglePropPayFinanceMenu() {
  const menu = document.getElementById('prop-pay-menu');
  if (!menu) return;
  const shouldOpen = !menu.classList.contains('open');
  closeAllMenus(shouldOpen ? 'prop-pay-menu' : '');
  menu.classList.toggle('open', shouldOpen);
}

function syncPropPayFinanceMenuMarks() {
  const all = document.getElementById('prop-pay-all');
  if (all) all.textContent = selectedPaymentFinanceFilter.size === 0 ? '✓' : '';
  const f = document.getElementById('prop-pay-full');
  const p = document.getElementById('prop-pay-partial');
  if (f) f.textContent = selectedPaymentFinanceFilter.has('مدفوع بشكل كامل') ? '✓' : '';
  if (p) p.textContent = selectedPaymentFinanceFilter.has('جزئي') ? '✓' : '';
  const btn = document.getElementById('filter-prop-pay-btn');
  if (btn) btn.textContent = selectedPaymentFinanceFilter.size ? `دفعات (${selectedPaymentFinanceFilter.size})` : 'مدفوع / جزئي';
}

function togglePropPayFinanceFilter(k) {
  if (selectedPaymentFinanceFilter.has(k)) selectedPaymentFinanceFilter.delete(k);
  else selectedPaymentFinanceFilter.add(k);
  syncPropPayFinanceMenuMarks();
  currentPage = 1;
  filterTable();
}

function toggleAllPropPayFinance() {
  selectedPaymentFinanceFilter.clear();
  syncPropPayFinanceMenuMarks();
  currentPage = 1;
  filterTable();
}

/* ─── EXPORT ─── */
function csvEscapeCell(val) {
  const s = String(val == null ? '' : val);
  if (/[",\n\r]/.test(s)) return '"' + s.replace(/"/g, '""') + '"';
  return s;
}

function exportPropertyOwnersCsvText(b, bi, om) {
  const stakes = b.propertyOwners || [];
  if (!stakes.length) return getResponsiblePersonOfBuilding(b, bi);
  return stakes.map(po => {
    const rowm = om[po.ownerId];
    const nm = rowm ? rowm.ownerName : po.holderName || po.ownerId;
    return `${nm} (${po.share})`;
  }).join(' | ');
}

function exportExcel() {
  const om = typeof getAuxOwnerRowMap === 'function' ? getAuxOwnerRowMap() : {};
  const header = [
    'ID العقار',
    'رقم العقار / اسم المحضر',
    'مالك العقار (والحصص)',
    'الدولة',
    'المحافظة',
    'فئة / نوع العقار',
    'تاريخ تملك العقار',
    'مساحة العقار (م²)',
    'الموقع الجغرافي',
    'ملاحظات عن العقار',
    'الحالة التشغيلية',
    'السعر التقريبي (USD)',
    'السعر الفعلي (USD)',
    'الدفعات المالية',
    'تفاصيل الدفع',
    'الباقي من الدفعات',
    'المدخل',
    'تاريخ ادخال البيانات',
    'تاريخ آخر تعديل'
  ];
  const rows = filteredData.map((b, idx) => {
    const bi = buildings.indexOf(b);
    const propertyKind = getPropertyKindOfBuilding(b, bi);
    const propertySubType = getPropertySubTypeOfBuilding(b, bi);
    const cat = propertyKind + (propertySubType ? ' — ' + propertySubType : '');
    const ownersTxt = exportPropertyOwnersCsvText(b, bi, om);
    const createdShown = b.createdAt || getRegistrationDateOfBuilding(b, bi);
    const approxVal = Number(b.approxPriceUsd);
    const actVal = Number(b.actualPriceUsd != null ? b.actualPriceUsd : b.value);
    return [
      b.propId || String(idx + 1),
      [b.propNo, b.mahder].filter(Boolean).join(' / ') || '-',
      ownersTxt,
      getCountryOfBuilding(b),
      b.city || '-',
      cat,
      b.ownDate || '-',
      b.area != null ? b.area : '',
      (b.geo || '').trim(),
      (b.details || '').replace(/[\r\n]+/g, ' '),
      b.operationalStatus || '',
      isFinite(approxVal) ? Math.round(approxVal) : '',
      isFinite(actVal) ? Math.round(actVal) : '',
      b.paymentFinanceStatus || '',
      (b.paymentDetailBlurb || b.payments || '').replace(/[\r\n]+/g, ' '),
      String(b.paymentRemainderLabel || '').replace(/[\r\n]+/g, ' '),
      getEnteredByOfBuilding(b, bi),
      createdShown,
      b.updatedAt || ''
    ];
  });
  const line = cells => cells.map(csvEscapeCell).join(',');
  let csv = '\uFEFF' + line(header) + '\n' + rows.map(r => line(r)).join('\n');
  const blob = new Blob([csv], {type:'text/csv;charset=utf-8'});
  const a = document.createElement('a'); a.href = URL.createObjectURL(blob);
  a.download = 'عقارات_المحفظة.csv'; a.click();
}

function printRegistryTablePdf() {
  document.body.classList.add('print-registry-table-only');
  const cleanup = () => {
    document.body.classList.remove('print-registry-table-only');
    window.removeEventListener('afterprint', cleanup);
  };
  window.addEventListener('afterprint', cleanup);
  requestAnimationFrame(() => {
    window.print();
    setTimeout(cleanup, 1000);
  });
}

function exportPDF() {
  printRegistryTablePdf();
}

/* ─── PAGE SWITCH ─── */
function openPropertyView(propNo) {
  const b = buildings.find(x => x.propNo === propNo);
  if (!b) return;
  const w = window.open('', '_blank');
  if (!w) return;
  const __pvRoot = document.documentElement;
  const __pvFs =
    __pvRoot.style.getPropertyValue('--fs-base').trim() ||
    getComputedStyle(__pvRoot).getPropertyValue('--fs-base').trim() ||
    '15px';
  const __pvFont =
    __pvRoot.style.getPropertyValue('--font-body').trim() ||
    getComputedStyle(__pvRoot).getPropertyValue('--font-body').trim() ||
    "'Tajawal', sans-serif";
  const pvBi = buildings.indexOf(b);
  const pvStakes = b.propertyOwners || [];
  const pvOm = getAuxOwnerRowMap();
  const pvOwnersTxt = exportPropertyOwnersCsvText(b, pvBi, pvOm);
  const pvKind = getPropertyKindOfBuilding(b, pvBi) + (getPropertySubTypeOfBuilding(b, pvBi) ? ' — ' + getPropertySubTypeOfBuilding(b, pvBi) : '');
  const pvApprox = Number(b.approxPriceUsd);
  const pvActual = Number(b.actualPriceUsd != null ? b.actualPriceUsd : b.value);
  w.document.write(`
    <html lang="ar" dir="rtl">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic:wght@400;500;600;700&family=Tajawal:wght@300;400;500;700&family=Amiri:ital,wght@0,400;0,700;1,400&family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
      <title>بيانات العقار ${b.propNo}</title>
      <style>
        :root { --fs-base: ${__pvFs}; --fs-scale: calc(var(--fs-base) / 15px); }
        body { font-family: ${__pvFont}; background:#0b0b0b; color:#f5f0e8; padding:24px; direction:rtl; }
        h1 { font-size: calc(22px * var(--fs-scale)); margin-bottom:16px; color:#D4AF37; }
        .field { margin-bottom:8px; }
        .label { color:#a3a3a3; font-size: calc(13px * var(--fs-scale)); }
        .value { font-size: calc(14px * var(--fs-scale)); }
        .section-title { margin-top:18px; margin-bottom:8px; color:#D4AF37; font-size: calc(15px * var(--fs-scale)); }
        ul { margin:0; padding-right:18px; }
        li { margin-bottom:4px; }
        .back-btn {
          display:inline-block;
          margin-bottom:16px;
          padding:6px 14px;
          border-radius:6px;
          border:1px solid #444;
          background:#111;
          color:#f5f0e8;
          font-size: calc(12px * var(--fs-scale));
          cursor:pointer;
        }
      </style>
    </head>
    <body>
      <button class="back-btn" onclick="window.close()">↩ العودة إلى لوحة العقارات</button>
      <h1>بيانات العقار ${b.propNo}</h1>
      <div class="field"><span class="label">ID العقار:</span> <span class="value">${escapeCellHtml(b.propId || '')}</span></div>
      <div class="field"><span class="label">اسم المحضر:</span> <span class="value">${escapeCellHtml(b.mahder || '-')}</span></div>
      <div class="field"><span class="label">اسم المبنى:</span> <span class="value">${escapeCellHtml(b.name)}</span></div>
      <div class="field"><span class="label">مالك العقار (والحصص):</span> <span class="value">${escapeCellHtml(pvOwnersTxt)}${pvStakes.length > 1 ? ' (' + pvStakes.length + ' ملاك)' : ''}</span></div>
      <div class="field"><span class="label">الدولة:</span> <span class="value">${escapeCellHtml(getCountryOfBuilding(b))}</span></div>
      <div class="field"><span class="label">المحافظة:</span> <span class="value">${escapeCellHtml(b.city)}</span></div>
      <div class="field"><span class="label">فئة / نوع العقار:</span> <span class="value">${escapeCellHtml(pvKind)}</span></div>
      <div class="field"><span class="label">تاريخ تملك العقار:</span> <span class="value">${escapeCellHtml(b.ownDate || '—')}</span></div>
      <div class="field"><span class="label">المساحة:</span> <span class="value">${formatAreaFromM2(b.area)}</span></div>
      <div class="field"><span class="label">الحالة التشغيلية:</span> <span class="value">${escapeCellHtml(b.operationalStatus || '')}</span></div>
      <div class="field"><span class="label">حالة السجل:</span> <span class="value">${escapeCellHtml(b.status || '')}</span></div>
      <div class="field"><span class="label">السعر التقريبي USD:</span> <span class="value">${isFinite(pvApprox) ? Math.round(pvApprox).toLocaleString('en-US') : '—'}</span></div>
      <div class="field"><span class="label">السعر الفعلي USD:</span> <span class="value">${isFinite(pvActual) ? Math.round(pvActual).toLocaleString('en-US') : '—'}</span></div>
      <div class="field"><span class="label">الدفعات المالية:</span> <span class="value">${escapeCellHtml(b.paymentFinanceStatus || '—')}</span></div>
      <div class="field"><span class="label">تفاصيل الدفع:</span> <span class="value">${escapeCellHtml(String(b.paymentDetailBlurb || b.payments || '—'))}</span></div>
      <div class="field"><span class="label">الباقي من الدفعات:</span> <span class="value">${escapeCellHtml(String(b.paymentRemainderLabel || '—'))}</span></div>
      <div class="field"><span class="label">المدخل:</span> <span class="value">${escapeCellHtml(getEnteredByOfBuilding(b, pvBi))}</span></div>
      <div class="field"><span class="label">تاريخ الإدخال / آخر تعديل:</span> <span class="value">${escapeCellHtml(b.createdAt || getRegistrationDateOfBuilding(b, pvBi))} — ${escapeCellHtml(b.updatedAt || '')}</span></div>
      <div class="section-title">بيانات تفصيلية</div>
      <div class="value">${escapeCellHtml(b.details || 'لا توجد بيانات تفصيلية.')}</div>
      <div class="section-title">تقرير العمليات</div>
      <ul>
        ${(b.opsDetails || []).map(item => `<li>${item}</li>`).join('')}
      </ul>
    </body>
    </html>
  `);
  w.document.close();
}

function openPropertyDetails(propNo) {
  const b = buildings.find(x => x.propNo === propNo);
  if (!b) return;
  const usdRate = 3.75; // SAR per 1 USD (تقريبي)
  const ua = (navigator.userAgent || '').toLowerCase();
  const isPhoneUA = /iphone|ipad|ipod|android|mobile|mobi/.test(ua);
  const isPhoneDetails =
    isPhoneUA ||
    isMobileNavMode() ||
    window.matchMedia('(max-width: 700px)').matches ||
    window.matchMedia('(max-device-width: 700px)').matches;
  const mapTarget = isPhoneDetails ? '_self' : '_blank';
  const valueUsd =
    (typeof b.value === 'number' && isFinite(b.value) && b.value > 0)
      ? (b.value / usdRate)
      : null;

  const operations = Array.isArray(b.operations) ? b.operations : [];
  const signals = Array.isArray(b.signals) ? b.signals : [];
  const attachments = Array.isArray(b.attachments) ? b.attachments : (Array.isArray(b.files) ? b.files : []);
  const payments = Array.isArray(b.paymentsUsd) ? b.paymentsUsd : (Array.isArray(b.payments) ? b.payments : []);

  const personIcon = `
    <span class="icon-inline person" aria-hidden="true">
      <svg viewBox="0 0 24 24" focusable="false">
        <path d="M12 12c2.76 0 5-2.35 5-5.25S14.76 1.5 12 1.5 7 3.85 7 6.75 9.24 12 12 12Zm0 2.25c-4.17 0-9 2.12-9 6.3V22.5h18v-1.95c0-4.18-4.83-6.3-9-6.3Z"/>
      </svg>
    </span>
  `;
  const icon = {
    map: `
      <span class="icon-inline" aria-hidden="true">
        <svg viewBox="0 0 24 24" focusable="false">
          <path d="M12 22s7-6.1 7-13a7 7 0 1 0-14 0c0 6.9 7 13 7 13Zm0-9.2a3.2 3.2 0 1 1 0-6.4 3.2 3.2 0 0 1 0 6.4Z"/>
        </svg>
      </span>
    `,
    link: `
      <span class="icon-inline" aria-hidden="true">
        <svg viewBox="0 0 24 24" focusable="false">
          <path d="M10.6 13.4a1 1 0 0 1 0-1.4l2.4-2.4a1 1 0 1 1 1.4 1.4l-2.4 2.4a1 1 0 0 1-1.4 0ZM8.5 15.5l-1.4 1.4a4 4 0 0 1-5.7-5.7l1.4-1.4a1 1 0 1 1 1.4 1.4L2.8 12.6a2 2 0 1 0 2.9 2.9l1.4-1.4a1 1 0 1 1 1.4 1.4Zm14.1-8.6-1.4 1.4a1 1 0 1 1-1.4-1.4l1.4-1.4a2 2 0 0 0-2.9-2.9L17 4a1 1 0 0 1-1.4-1.4l1.4-1.4a4 4 0 0 1 5.7 5.7Z"/>
        </svg>
      </span>
    `,
    doc: `
      <span class="icon-inline" aria-hidden="true">
        <svg viewBox="0 0 24 24" focusable="false">
          <path d="M7 2h7l5 5v15a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2Zm7 1.5V8h4.5"/>
          <path d="M8 12h8M8 16h8M8 20h6" />
        </svg>
      </span>
    `,
    cal: `
      <span class="icon-inline" aria-hidden="true">
        <svg viewBox="0 0 24 24" focusable="false">
          <path d="M7 2a1 1 0 0 1 1 1v1h8V3a1 1 0 1 1 2 0v1h1a3 3 0 0 1 3 3v13a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h1V3a1 1 0 0 1 1-1Zm14 8H3v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V10Z"/>
        </svg>
      </span>
    `,
    money: `
      <span class="icon-inline" aria-hidden="true">
        <svg viewBox="0 0 24 24" focusable="false">
          <path d="M3 6h18v12H3V6Zm2 2v8h14V8H5Zm7 7a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/>
        </svg>
      </span>
    `,
    share: `
      <span class="icon-inline" aria-hidden="true">
        <svg viewBox="0 0 24 24" focusable="false">
          <path d="M4 19h16v2H4v-2Zm2-2V5h3v12H6Zm5 0V9h3v8h-3Zm5 0V3h3v14h-3Z"/>
        </svg>
      </span>
    `,
    note: `
      <span class="icon-inline" aria-hidden="true">
        <svg viewBox="0 0 24 24" focusable="false">
          <path d="M4 3h16a2 2 0 0 1 2 2v14l-4-3H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Zm3 4h10M7 11h10"/>
        </svg>
      </span>
    `,
    file: `
      <span class="icon-inline" aria-hidden="true">
        <svg viewBox="0 0 24 24" focusable="false">
          <path d="M14 2H7a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7l-5-5Zm0 1.5V8h4.5"/>
        </svg>
      </span>
    `
  };

  const opsHtml = operations.length
    ? operations.map((op, idx) => `
        <details class="subsection-item" ${(isPhoneDetails || idx === 0) ? 'open' : ''}>
          <summary>
            <span style="display:flex;align-items:center;gap:8px;">
              <span class="subsec-num" style="width:22px;height:22px;font-size:calc(9px * var(--fs-scale))">${idx + 1}</span>
              عملية رقم ${idx + 1}
            </span>
            <span style="display:flex;align-items:center;gap:8px;">
              <span class="pill">${op.type || 'غير محدد'}</span>
              <span class="summary-arrow">›</span>
            </span>
          </summary>
          <div class="subsection-body">
            <div class="field-grid">
              <div class="field"><span class="label">نوع العملية</span><span class="value">${op.type ? `${icon.share}${op.type}` : '-'}</span></div>
              <div class="field"><span class="label">مقدار التصرف</span><span class="value">${op.amount != null ? `${icon.money}${op.amount}` : '-'}</span></div>
              <div class="field"><span class="label">وحدة التصرف</span><span class="value">${op.unit ? `${icon.share}${op.unit}` : '-'}</span></div>
              <div class="field"><span class="label">طريقة العملية</span><span class="value">${op.method ? `${icon.doc}${op.method}` : '-'}</span></div>
              <div class="field"><span class="label">رقم العقد</span><span class="value">${op.contractNo ? `${icon.doc}${op.contractNo}` : '-'}</span></div>
              <div class="field"><span class="label">تاريخ العقد</span><span class="value">${op.contractDate ? `${icon.cal}${op.contractDate}` : '-'}</span></div>
              <div class="field"><span class="label">الشاهد الأول</span><span class="value">${op.witness1 ? `${personIcon}${op.witness1}` : '-'}</span></div>
              <div class="field"><span class="label">الشاهد الثاني</span><span class="value">${op.witness2 ? `${personIcon}${op.witness2}` : '-'}</span></div>
            </div>
            <div class="field-full" style="margin-top:12px;">
              <span class="label">ملاحظات العقد</span>
              <span class="value">${op.notes ? `${icon.note}${op.notes}` : '-'}</span>
            </div>
            <div class="two-cols" style="margin-top:14px;">
              <div class="mini">
                <div class="mini-title">المالكون السابقون</div>
                <div class="mini-value">${Array.isArray(op.prevOwners) && op.prevOwners.length ? `${personIcon}${op.prevOwners.join('، ')}` : '—'}</div>
              </div>
              <div class="mini">
                <div class="mini-title">المالكون الجدد</div>
                <div class="mini-value">${Array.isArray(op.newOwners) && op.newOwners.length ? `${personIcon}${op.newOwners.join('، ')}` : '—'}</div>
              </div>
              <div class="mini">
                <div class="mini-title">أعضاء الفريق الأول</div>
                <div class="mini-value">${Array.isArray(op.team1) && op.team1.length ? `${personIcon}${op.team1.join('، ')}` : '—'}</div>
              </div>
              <div class="mini">
                <div class="mini-title">أعضاء الفريق الثاني</div>
                <div class="mini-value">${Array.isArray(op.team2) && op.team2.length ? `${personIcon}${op.team2.join('، ')}` : '—'}</div>
              </div>
            </div>
          </div>
        </details>
      `).join('')
    : `<div class="empty">لا توجد عمليات مسجلة حاليًا. (يدعم أكثر من عملية)</div>`;

  const signalsHtml = signals.length
    ? signals.map((s, idx) => `
        <details class="subsection-item" ${(isPhoneDetails || idx === 0) ? 'open' : ''}>
          <summary>
            <span style="display:flex;align-items:center;gap:8px;">
              <span class="subsec-num" style="width:22px;height:22px;font-size:calc(9px * var(--fs-scale))">${idx + 1}</span>
              إشارة رقم ${idx + 1}
            </span>
            <span style="display:flex;align-items:center;gap:8px;">
              <span class="pill">${s.type || 'غير محدد'}</span>
              <span class="summary-arrow">›</span>
            </span>
          </summary>
          <div class="subsection-body">
            <div class="field-grid">
              <div class="field"><span class="label">معرّف الإشارة</span><span class="value">${s.signalId ? `${icon.doc}${escapeCellHtml(s.signalId)}` : '-'}</span></div>
              <div class="field"><span class="label">رقم عقد الإشارة</span><span class="value">${s.no ? `${icon.doc}${escapeCellHtml(s.no)}` : '-'}</span></div>
              <div class="field"><span class="label">تاريخ الإشارة</span><span class="value">${s.date ? `${icon.cal}${escapeCellHtml(s.date)}` : '-'}</span></div>
              <div class="field"><span class="label">نوع الإشارة</span><span class="value">${s.type ? `${icon.note}${escapeCellHtml(s.type)}` : '-'}</span></div>
            </div>
            <div class="field-full" style="margin-top:12px;">
              <span class="label">ملاحظات الإشارة</span>
              <span class="value">${s.notes ? `${icon.note}${escapeCellHtml(s.notes)}` : '-'}</span>
            </div>
            <div class="two-cols" style="margin-top:14px;">
              <div class="mini">
                <div class="mini-title">أصحاب الإشارة</div>
                <div class="mini-value">${Array.isArray(s.owners) && s.owners.length ? `${personIcon}${s.owners.join('، ')}` : '—'}</div>
              </div>
              <div class="mini">
                <div class="mini-title">المدعى عليهم في الإشارة</div>
                <div class="mini-value">${Array.isArray(s.defendants) && s.defendants.length ? `${personIcon}${s.defendants.join('، ')}` : '—'}</div>
              </div>
            </div>
          </div>
        </details>
      `).join('')
    : `<div class="empty">لا توجد إشارات حاليًا. (يدعم أكثر من إشارة)</div>`;

  const attachmentsHtml = attachments.length
    ? attachments.map((f, idx) => `
        <div class="row-line">
          <div class="row-main">
            <div class="row-title">${f.name || f.fileName || `ملف ${idx + 1}`}</div>
            <div class="row-sub">${f.issuedAt || f.date || 'بدون تاريخ'}</div>
          </div>
          <div class="row-actions">
            <button class="topbar-btn ghost" type="button" onclick="alert('ربط التحميل لاحقًا');">رفع/عرض</button>
          </div>
        </div>
      `).join('')
    : `<div class="empty">لا توجد ملفات مرفقة. (يدعم أكثر من ملف)</div>`;

  const paymentsHtml = payments.length
    ? payments.map((p, idx) => `
        <div class="row-line">
          <div class="row-main">
            <div class="row-title">دفعة ${idx + 1}</div>
            <div class="row-sub">${p.date || p.paidAt || 'بدون تاريخ'}</div>
          </div>
          <div class="row-meta">
            <span class="pill">${p.amountUsd != null ? formatUsdMoney(Number(p.amountUsd)) : (p.amount || '—')}</span>
          </div>
        </div>
      `).join('')
    : `<div class="empty">لا توجد دفعات حاليًا. (يدعم أكثر من دفعة)</div>`;

  const detailBi = buildings.indexOf(b);
  const detailOm = getAuxOwnerRowMap();
  const detailStakes = b.propertyOwners || [];
  const detailPropId = b.propId || '';
  const detailSigAux = propertySignalsFromAux(detailPropId);
  const detailAttAux = propertyAttachmentsFromAux(detailPropId);
  const detailSubType = getPropertySubTypeOfBuilding(b, detailBi);
  const detailPropKind = getPropertyKindOfBuilding(b, detailBi) + (detailSubType ? ' — ' + detailSubType : '');
  const detailCreated = b.createdAt || getRegistrationDateOfBuilding(b, detailBi);
  const detailApproxUsd = Number(b.approxPriceUsd);
  const detailActualUsdRaw = b.actualPriceUsd != null ? b.actualPriceUsd : b.value;
  const detailActualUsd = Number(detailActualUsdRaw);
  const detailOwnersCsv = exportPropertyOwnersCsvText(b, detailBi, detailOm);

  const detailHeroStakesHtml = !detailStakes.length
    ? `<div class="hero-row"><div class="quick-item important hero"><div class="k">مالك العقار (السجل المرجعي)</div><div class="v">${escapeCellHtml(getResponsiblePersonOfBuilding(b, detailBi))}</div></div></div>`
    : (detailStakes.length <= 3
      ? `<div class="hero-row">${detailStakes.map(po => {
        const rr = detailOm[po.ownerId];
        const nm = rr ? rr.ownerName : po.holderName || po.ownerId;
        const pct = parseFloat(String(po.share).replace(/[%٪]/g, '').replace(/,/g, '.')) || 0;
        const bar = pct > 0 && pct <= 100 ? `<div class="share-bar-wrap"><div class="share-bar-fill" style="width:${pct.toFixed(1)}%"></div></div>` : '';
        return `<div class="quick-item important hero"><div class="k">${escapeCellHtml(nm)}</div><div class="v">${escapeCellHtml(po.share)}</div>${bar}</div>`;
      }).join('')}</div>`
      : `<table class="simple" style="margin-top:12px;width:100%"><thead><tr><th>المالك</th><th>الحصة</th></tr></thead><tbody>${detailStakes.map(po => {
        const rr = detailOm[po.ownerId];
        const nm = rr ? rr.ownerName : po.holderName || po.ownerId;
        return `<tr><td>${escapeCellHtml(nm)}</td><td>${escapeCellHtml(po.share)}</td></tr>`;
      }).join('')}</tbody></table>`);

  const rawGeoDetail = String(b.geo || '').trim();
  const iframeSrcDetail = /^https:\/\/www\.google\.com\/maps\/embed/i.test(rawGeoDetail)
    ? rawGeoDetail
    : ('https://maps.google.com/maps?q=' + encodeURIComponent(`${b.city || ''} ${b.name || ''}`.trim()) + '&output=embed');
  const iframeSafeDetail = iframeSrcDetail.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;');
  const detailMapBlockHtml = `<div style="margin-top:10px;border-radius:12px;overflow:hidden;border:1px solid rgba(212,175,55,.2)"><iframe title="الموقع الجغرافي" loading="lazy" style="border:0;width:100%;min-height:240px;background:#111" src="${iframeSafeDetail}"></iframe></div>${rawGeoDetail ? `<div style="margin-top:8px"><a class="map-link" href="${escapeCellHtml(rawGeoDetail)}" target="${mapTarget}" rel="noopener noreferrer">${icon.link} الرابط المحفوظ للموقع</a></div>` : ''}`;

  const signalsCombinedHtml = detailSigAux.length
    ? detailSigAux.map((sig, idx) => {
      const nl = (sig.notesLines || []).map(l => escapeCellHtml(l)).join('<br/>');
      const files = (sig.fileNames || []).map(f => escapeCellHtml(f)).join('، ');
      return `
        <details class="subsection-item" ${(isPhoneDetails || idx === 0) ? 'open' : ''}>
          <summary>
            <span style="display:flex;align-items:center;gap:8px;">
              <span class="subsec-num">${idx + 1}</span>
              ${escapeCellHtml(sig.signalId)} — ${escapeCellHtml(sig.signalContractNo)}
            </span>
            <span style="display:flex;align-items:center;gap:8px;">
              <span class="pill">${escapeCellHtml(sig.signalType || '—')}</span>
              <span class="summary-arrow">›</span>
            </span>
          </summary>
          <div class="subsection-body">
            <div class="field-grid">
              <div class="field"><span class="label">تاريخ الإشارة</span><span class="value">${sig.signalDate ? `${icon.cal}${escapeCellHtml(sig.signalDate)}` : '—'}</span></div>
              <div class="field"><span class="label">صاحب الإشارة</span><span class="value">${escapeCellHtml(auxFormatOwnerLabels(sig.claimantOwnerIds || []).join('، ') || '—')}</span></div>
              <div class="field"><span class="label">المدعى عليهم</span><span class="value">${escapeCellHtml(auxFormatOwnerLabels((sig.defendantOwnerIds || []).filter(Boolean)).join('، ') || '—')}</span></div>
            </div>
            ${nl ? `<div class="field-full" style="margin-top:12px"><span class="label">ملاحظات</span><span class="value">${nl}</span></div>` : ''}
            ${files ? `<div class="field-full" style="margin-top:8px"><span class="label">الملفات المرتبطة</span><span class="value">${files}</span></div>` : ''}
          </div>
        </details>`;
    }).join('')
    : signalsHtml;

  const attachmentsCombinedHtml = detailAttAux.length
    ? detailAttAux.map(att => `
        <div class="row-line">
          <div class="row-main">
            <div class="row-title">${escapeCellHtml(att.attachmentName)} <span style="opacity:.85">(${escapeCellHtml(att.attachmentId)})</span></div>
            <div class="row-sub">${escapeCellHtml(att.attachmentNo || '')} — ${escapeCellHtml(att.attachmentDate || '')}${att.summaryLine ? ` — ${escapeCellHtml(att.summaryLine)}` : ''}</div>
          </div>
          <div class="row-actions">
            <button class="topbar-btn ghost" type="button" onclick="alert(${JSON.stringify(String(att.downloadName || att.attachmentId || ''))});">${icon.file} تنزيل</button>
          </div>
        </div>
      `).join('')
    : attachmentsHtml;

  const csvRows = [
    ['القسم', 'الحقل', 'القيمة'],
    ['معرّف', 'ID العقار', String(detailPropId || '')],
    ['معرّف', 'رقم العقار / المحضر', [b.propNo, b.mahder].filter(Boolean).join(' / ') || '-'],
    ['ملاك', 'مالك العقار (والحصص)', detailOwnersCsv],
    ['موقع وتصنيف', 'الدولة', String(getCountryOfBuilding(b) || '')],
    ['موقع وتصنيف', 'المحافظة', String(b.city || '')],
    ['موقع وتصنيف', 'فئة / نوع العقار', detailPropKind],
    ['تواريخ ومساحة', 'تاريخ تملك العقار', String(b.ownDate || '')],
    ['تواريخ ومساحة', 'مساحة (م²)', typeof b.area === 'number' ? String(b.area) : '-'],
    ['تواريخ ومساحة', 'الموقع الجغرافي', (b.geo || '').replace(/[\r\n]+/g, ' ')],
    ['تشغيل ومالية', 'الحالة التشغيلية', String(b.operationalStatus || '')],
    ['تشغيل ومالية', 'حالة السجل الداخلية', String(b.status || '')],
    ['تشغيل ومالية', 'السعر التقريبي (USD)', isFinite(detailApproxUsd) ? String(Math.round(detailApproxUsd)) : ''],
    ['تشغيل ومالية', 'السعر الفعلي (USD)', isFinite(detailActualUsd) ? String(Math.round(detailActualUsd)) : ''],
    ['تشغيل ومالية', 'الدفعات المالية', String(b.paymentFinanceStatus || '')],
    ['تشغيل ومالية', 'تفاصيل الدفع', String(b.paymentDetailBlurb || b.payments || '').replace(/[\r\n]+/g, ' ')],

    ['وصف', 'ملاحظات عن العقار', String(b.details || '').replace(/[\r\n]+/g, ' ')],
    ['إدخال', 'المدخل', String(getEnteredByOfBuilding(b, detailBi) || '')],
    ['إدخال', 'تاريخ ادخال البيانات', String(detailCreated || '')],
    ['إدخال', 'تاريخ آخر تعديل', String(b.updatedAt || '')],
    ['إشارات وملحقات', 'عدد الإشارات المرتبطة (تقرير الإشارات)', String(detailSigAux.length)],
    ['إشارات وملحقات', 'عدد الملحقات (تقرير الملحقات)', String(detailAttAux.length)]
  ];
  const csvText = '\uFEFF' + csvRows.map(r => r.map(c => csvEscapeCell(c)).join(',')).join('\n');
  const __popupRoot = document.documentElement;
  const __popupFs =
    __popupRoot.style.getPropertyValue('--fs-base').trim() ||
    getComputedStyle(__popupRoot).getPropertyValue('--fs-base').trim() ||
    '15px';
  const __popupFont =
    __popupRoot.style.getPropertyValue('--font-body').trim() ||
    getComputedStyle(__popupRoot).getPropertyValue('--font-body').trim() ||
    "'Tajawal', sans-serif";
  // Gather all active settings to inject into the popup
  const __popupPrefs = getPrefs();
  const __popupTheme = __popupRoot.getAttribute('data-theme') || __popupPrefs.theme || 'dark';
  const __popupIsLight = __popupTheme === 'light';
  // Panel color → background for card sections
  const __panelColorMap = {
    default: { dark: { bg: '#1A1A1A', border: '#2A2A2A', head: '#111111' }, light: { bg: '#ffffff', border: '#dfd5c6', head: '#fbf7ee' } },
    plum:    { dark: { bg: '#1E1428', border: '#3E2860', head: '#180F22' }, light: { bg: '#EDE0F8', border: '#C4A0E0', head: '#E0CDF4' } },
    slate:   { dark: { bg: '#1E2530', border: '#3A4558', head: '#1A2030' }, light: { bg: '#EEF2F8', border: '#BCC8DC', head: '#E4EAF4' } },
    navy:    { dark: { bg: '#111A2E', border: '#2A3F6A', head: '#0D1526' }, light: { bg: '#DDE8F8', border: '#96B8E8', head: '#C8D9F4' } },
    forest:  { dark: { bg: '#111E18', border: '#26432E', head: '#0D1A13' }, light: { bg: '#D8F0E0', border: '#88C49A', head: '#C2E6CE' } },
    stone:   { dark: { bg: '#1E1C18', border: '#3D3830', head: '#191712' }, light: { bg: '#EDE8DE', border: '#C0AE90', head: '#E2D9C8' } },
    rose:    { dark: { bg: '#241420', border: '#5C2845', head: '#1C0D19' }, light: { bg: '#F8E4EE', border: '#DDA0BF', head: '#F2D0E4' } },
    teal:    { dark: { bg: '#0F1E20', border: '#1E4A50', head: '#0A1618' }, light: { bg: '#D8F0EE', border: '#80C8C4', head: '#C0E6E4' } },
    gold:    { dark: { bg: '#201A0A', border: '#5A4510', head: '#181200' }, light: { bg: '#FDF3D8', border: '#D4AF5A', head: '#F8E8B8' } },
  };
  const __pc = __popupPrefs.panelColor || 'plum';
  const __panelPalette = (__panelColorMap[__pc] || __panelColorMap.plum)[__popupIsLight ? 'light' : 'dark'];
  // Font color
  const __fontColorMap = {
    default: { dark: { primary: '#F5F0E8', secondary: '#B0A898', muted: '#6B6560' }, light: { primary: '#2d2418', secondary: '#5e5243', muted: '#7b6f60' } },
    ivory:   { dark: { primary: '#F5F0E8', secondary: '#DCCFB7', muted: '#B6A98E' }, light: { primary: '#2D2418', secondary: '#645845', muted: '#867864' } },
    gold:    { dark: { primary: '#E8C96A', secondary: '#D8B44F', muted: '#A48A46' }, light: { primary: '#7A5B16', secondary: '#9B7522', muted: '#B08A3B' } },
    silver:  { dark: { primary: '#E6EBF2', secondary: '#C6CEDB', muted: '#95A0B2' }, light: { primary: '#2C3748', secondary: '#4C5A6F', muted: '#6B788B' } },
    mint:    { dark: { primary: '#DDF8EE', secondary: '#AEE7D1', muted: '#79B79D' }, light: { primary: '#1E5E4B', secondary: '#2F7861', muted: '#4A9078' } },
    rose:    { dark: { primary: '#F8E5EC', secondary: '#E7BBCB', muted: '#B98297' }, light: { primary: '#6A3245', secondary: '#8A4760', muted: '#A26179' } },
  };
  const __fc = __popupPrefs.fontColor || 'default';
  const __fontPalette = (__fontColorMap[__fc] || __fontColorMap.default)[__popupIsLight ? 'light' : 'dark'];
  // Body background based on theme
  const __bodyBg = __popupIsLight ? '#f7f4ee' : '#0A0A0A';
  const __bodyColor = __fontPalette.primary;
  const detailsHtml = `
    <html lang="ar" dir="rtl">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic:wght@400;500;600;700&family=Tajawal:wght@300;400;500;700&family=Amiri:ital,wght@0,400;0,700;1,400&family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
      <title>بيانات العقار ${b.propNo}</title>
      <style>
        :root {
          --fs-base: ${__popupFs};
          --fs-scale: calc(var(--fs-base) / 15px);
          --gold-deep:    #8B6914;
          --gold-mid:     #C49A2A;
          --gold-bright:  #D4AF37;
          --gold-light:   #E8C96A;
          --gold-pale:    #F5E9C0;
          --black-pure:   ${__bodyBg};
          --black-rich:   ${__panelPalette.head};
          --black-card:   ${__panelPalette.bg};
          --black-border: ${__panelPalette.border};
          --ivory-warm:   ${__fontPalette.primary};
          --ivory-mid:    ${__fontPalette.secondary};
          --text-primary: ${__fontPalette.primary};
          --text-secondary: ${__fontPalette.secondary};
          --text-muted:   ${__fontPalette.muted};
          --accent:       var(--gold-bright);
          --border:       ${__panelPalette.border};
          --font-display: ${__popupFont};
          --font-body:    ${__popupFont};
          --font-ui:      ${__popupFont};
          --shadow-gold: 0 0 28px rgba(212,175,55,.22);
          --shadow-card: 0 8px 40px rgba(0,0,0,.6);
          --r-sm: 6px;
          --r-md: 10px;
          --r-lg: 18px;
          --card-bg: ${__panelPalette.bg};
          --card-border: ${__panelPalette.border};
          --card-head: ${__panelPalette.head};
        }
        * { box-sizing:border-box; font-family: var(--font-body) !important; }
        html, body { font-family: var(--font-body) !important; }
        body {
          margin:0;
          min-height:100vh;
          font-family: var(--font-body);
          background: var(--black-pure);
          color: var(--text-primary);
          padding:28px 36px 44px;
          direction:rtl;
          line-height:1.75;
          font-size: calc(16px * var(--fs-scale));
          -webkit-font-smoothing: antialiased;
          -moz-osx-font-smoothing: grayscale;
          text-rendering: geometricPrecision;
        }
        body::before {
          content:'';
          position:fixed;
          inset:-240px;
          background:
            radial-gradient(circle at 20% 10%, rgba(212,175,55,.10), transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(196,154,42,.07), transparent 55%),
            radial-gradient(circle at 50% 90%, rgba(232,201,106,.06), transparent 50%);
          pointer-events:none;
          z-index:-1;
        }
        /* ── Page title ── */
        h1 {
          font-family: var(--font-display);
          font-size: calc(30px * var(--fs-scale));
          margin:0 0 20px;
          color: var(--text-primary);
          letter-spacing:.02em;
          display:flex;
          align-items:baseline;
          gap:10px;
          flex-wrap:wrap;
        }
        h1 span { color: var(--gold-bright); font-size: calc(22px * var(--fs-scale)); }
        /* ── Property ID badge in title ── */
        .prop-id-tag {
          display:inline-flex;
          align-items:center;
          gap:6px;
          padding:4px 14px;
          border-radius:999px;
          border:1px solid rgba(212,175,55,.35);
          background:linear-gradient(135deg,rgba(212,175,55,.14),rgba(0,0,0,.45));
          font-size:calc(13px * var(--fs-scale));
          color:var(--gold-bright);
          font-weight:700;
          letter-spacing:.08em;
          vertical-align:middle;
          box-shadow:0 0 14px rgba(212,175,55,.15);
        }
        /* ── Status badge ── */
        .status-badge {
          display:inline-flex;
          align-items:center;
          gap:5px;
          padding:4px 12px;
          border-radius:999px;
          font-size:calc(11px * var(--fs-scale));
          font-weight:700;
          letter-spacing:.04em;
          vertical-align:middle;
        }
        .status-badge.owned {
          background:rgba(34,197,94,.14);
          border:1px solid rgba(34,197,94,.35);
          color:#4ade80;
        }
        .status-badge.partial {
          background:rgba(234,179,8,.12);
          border:1px solid rgba(234,179,8,.35);
          color:#fbbf24;
        }
        .status-badge.other {
          background:rgba(148,163,184,.10);
          border:1px solid rgba(148,163,184,.28);
          color:#94a3b8;
        }
        .status-badge.status-active {
          background:rgba(74,222,128,.12);
          border:1px solid rgba(74,222,128,.28);
          color:#4ade80;
        }
        .status-badge.status-partial {
          background:rgba(212,175,55,.12);
          border:1px solid rgba(212,175,55,.35);
          color:var(--gold-light);
        }
        .status-badge.status-pending {
          background:rgba(148,163,184,.10);
          border:1px solid rgba(148,163,184,.28);
          color:#94a3b8;
        }

        /* same button feel used across the website */
        .topbar-btn {
          padding: 10px 22px;
          border-radius: var(--r-sm);
          font-family: var(--font-body);
          font-size: calc(14px * var(--fs-scale));
          cursor: pointer;
          transition: all .2s;
          border: 1px solid rgba(212,175,55,.3);
          background: rgba(212,175,55,.08);
          color: var(--gold-light);
          display:inline-flex;
          align-items:center;
          gap:10px;
          white-space:nowrap;
        }
        .topbar-btn.export {
          padding: 12px 26px;
          font-size: calc(15px * var(--fs-scale));
          border-radius: 12px;
          border-color: rgba(212,175,55,.45);
          background: linear-gradient(135deg, rgba(212,175,55,.16), rgba(0,0,0,.30));
          box-shadow:
            0 10px 28px rgba(0,0,0,.55),
            0 0 24px rgba(212,175,55,.16);
        }
        .topbar-btn.export:hover {
          background: linear-gradient(135deg, rgba(212,175,55,.22), rgba(0,0,0,.22));
          border-color: rgba(212,175,55,.65);
          transform: translateY(-1px);
        }
        .topbar-btn:hover {
          background: rgba(212,175,55,.15);
          border-color: rgba(212,175,55,.5);
          transform: translateY(-1px);
        }
        .topbar-btn.ghost {
          background: transparent;
          border-color: rgba(212,175,55,.18);
          color: var(--text-secondary);
        }
        .topbar-btn.ghost:hover {
          background: rgba(212,175,55,.07);
          border-color: rgba(212,175,55,.35);
          color: var(--ivory-warm);
        }
        .btn-icon { display:inline-flex; align-items:center; justify-content:center; font-size: calc(15px * var(--fs-scale)); }
        .btn-icon svg { width:18px; height:18px; fill: var(--gold-bright); }
        .toolbar {
          display:grid;
          grid-template-columns: 1fr 1fr;
          align-items:center;
          gap:14px 16px;
          margin-bottom:22px;
          padding:12px 14px;
          border-radius: var(--r-lg);
          border: 1px solid rgba(212,175,55,.14);
          background: linear-gradient(135deg, rgba(212,175,55,.07), rgba(17,17,17,.92));
          box-shadow: var(--shadow-card);
          backdrop-filter: blur(10px);
        }
        .toolbar-left {
          display:flex;
          align-items:center;
          gap:12px;
          flex-wrap:wrap;
          justify-self:start; /* right side in RTL */
          justify-content:flex-start;
        }
        .toolbar-center {
          display:none;
        }
        .property-id-pill {
          display:inline-flex;
          align-items:center;
          gap:8px;
          padding:10px 18px;
          border-radius:999px;
          border:1px solid rgba(212,175,55,.22);
          background: linear-gradient(135deg, rgba(212,175,55,.12), rgba(0,0,0,.72));
          box-shadow: 0 0 18px rgba(212,175,55,.16);
        }
        .property-id-label {
          font-size: calc(13px * var(--fs-scale));
          color: var(--text-muted);
          font-family: var(--font-ui);
        }
        .property-id-value {
          font-size: calc(15px * var(--fs-scale));
          color: var(--gold-bright);
          font-weight:600;
          letter-spacing:.04em;
        }
        .toolbar-right {
          display:flex;
          align-items:center;
          gap:10px;
          justify-self:end;
          justify-content:flex-end;
          flex-wrap:wrap;
        }

        /* ── Toolbar Gear Button ── */
        #toolbar-qs-btn {
          width: 44px; height: 44px;
          border-radius: 12px;
          border: 1px solid rgba(212,175,55,.42);
          background: linear-gradient(145deg, rgba(22,22,22,.95), rgba(10,10,10,.88));
          color: var(--gold-bright);
          cursor: pointer;
          display: flex; align-items: center; justify-content: center;
          box-shadow: 0 4px 18px rgba(0,0,0,.45), 0 0 14px rgba(212,175,55,.12);
          transition: transform .25s cubic-bezier(.34,1.56,.64,1), border-color .2s, box-shadow .2s;
          flex-shrink: 0;
          padding: 0;
        }
        #toolbar-qs-btn:hover {
          transform: scale(1.08) rotate(30deg);
          border-color: rgba(212,175,55,.70);
          box-shadow: 0 6px 24px rgba(0,0,0,.55), 0 0 20px rgba(212,175,55,.22);
        }
        #toolbar-qs-btn svg { width: 20px; height: 20px; }
        .search-wrapper {
          position:relative;
          min-width:280px;
        }
        .search-input {
          width:100%;
          padding:10px 40px 10px 14px;
          border-radius:999px;
          border:1px solid rgba(212,175,55,.20);
          background: rgba(10,10,10,.65);
          color: var(--text-primary);
          font-family: var(--font-body);
          font-size: calc(13px * var(--fs-scale));
          outline:none;
          transition: border-color .18s ease, box-shadow .18s ease, background .18s ease;
        }
        .search-input:focus {
          border-color: rgba(212,175,55,.48);
          box-shadow: 0 0 0 3px rgba(212,175,55,.12);
          background: rgba(10,10,10,.82);
        }
        .search-input::placeholder {
          color: var(--text-muted);
        }
        .search-icon {
          position:absolute;
          right:12px;
          top:50%;
          transform:translateY(-50%);
          color: var(--gold-bright);
          font-size: calc(14px * var(--fs-scale));
        }
        /* legacy btn styles removed (use .topbar-btn like the website) */
        .sections {
          display:flex;
          flex-direction:column;
          gap:22px;
        }

        /* ── Section cards ── */
        .section-card {
          border-radius: var(--r-lg);
          border: 1px solid var(--card-border);
          background: var(--card-bg);
          backdrop-filter: blur(12px);
          padding:22px 24px 20px;
          box-shadow: var(--shadow-card);
          position:relative;
          overflow:hidden;
        }
        .section-card::before {
          content:'';
          position:absolute;
          top:0; right:0; left:0;
          height:3px;
          background:linear-gradient(to left, var(--gold-deep), var(--gold-bright), var(--gold-deep));
          border-radius: var(--r-lg) var(--r-lg) 0 0;
        }
        .section-header {
          display:flex;
          justify-content:space-between;
          align-items:center;
          margin-bottom:14px;
        }
        .section-title {
          color: var(--gold-bright);
          font-size: calc(14px * var(--fs-scale));
          font-weight:600;
          font-family: var(--font-ui);
          letter-spacing:.04em;
        }
        .section-sub {
          font-size: calc(12px * var(--fs-scale));
          color: var(--text-muted);
        }

        /* ── Field grid (main data layout) ── */
        .field-grid {
          display:grid;
          grid-template-columns:repeat(auto-fit, minmax(190px,1fr));
          gap:12px 22px;
        }
        .field {
          background:rgba(212,175,55,.04);
          border:1px solid rgba(212,175,55,.10);
          border-radius:10px;
          padding:10px 12px;
          transition:border-color .18s;
        }
        .field:hover { border-color:rgba(212,175,55,.22); }
        .label {
          color: var(--text-muted);
          font-size: calc(11px * var(--fs-scale));
          display:flex;
          align-items:center;
          gap:4px;
          margin-bottom:5px;
          font-family: var(--font-ui);
          letter-spacing:.03em;
          text-transform:uppercase;
        }
        .value {
          font-size: calc(14px * var(--fs-scale));
          color: var(--text-primary);
          font-weight:500;
          line-height:1.5;
        }
        .field-full {
          grid-column: 1 / -1;
          background:rgba(212,175,55,.04);
          border:1px solid rgba(212,175,55,.10);
          border-radius:10px;
          padding:12px 14px;
        }
        .field-full .label { margin-bottom:6px; }
        .field-full .value { font-size:calc(13px * var(--fs-scale)); line-height:1.7; color:var(--text-secondary); }

        a.map-link {
          color:#7fb8ff;
          text-decoration:none;
          font-size: calc(13px * var(--fs-scale));
          font-weight:600;
        }
        a.map-link:hover {
          text-decoration:underline;
          color:#b7d6ff;
        }
        ul { margin:4px 0 0; padding-right:20px; }
        li { margin-bottom:6px; font-size: calc(13px * var(--fs-scale)); }
        .muted { color: var(--text-muted); font-size: calc(12px * var(--fs-scale)); }

        /* ── Quick summary grid (top) ── */
        .quick-grid {
          display:grid;
          grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
          gap:12px 16px;
          margin-top:8px;
        }
        .quick-item {
          border: 1px solid rgba(212,175,55,.14);
          background: rgba(0,0,0,.20);
          border-radius: 13px;
          padding:12px 14px;
          transition:border-color .18s, box-shadow .18s;
        }
        .quick-item:hover {
          border-color:rgba(212,175,55,.28);
          box-shadow:0 4px 16px rgba(0,0,0,.3);
        }
        .quick-item.important {
          border-color: rgba(212,175,55,.42);
          background:
            radial-gradient(circle at top right, rgba(212,175,55,.16), rgba(0,0,0,.50));
          box-shadow:
            0 12px 36px rgba(0,0,0,.50),
            0 0 22px rgba(212,175,55,.14);
          padding:14px 16px;
        }
        .quick-item.important .k {
          color: var(--gold-light);
          font-size: calc(11px * var(--fs-scale));
          letter-spacing:.04em;
          text-transform:uppercase;
        }
        .quick-item.important .v {
          font-size: calc(17px * var(--fs-scale));
          color: var(--text-primary);
          font-weight:700;
        }
        .quick-item .k {
          font-size: calc(11px * var(--fs-scale));
          color: var(--text-muted);
          font-family: var(--font-ui);
          margin-bottom:5px;
          letter-spacing:.02em;
          text-transform:uppercase;
        }
        .quick-item .v {
          font-size: calc(14px * var(--fs-scale));
          color: var(--text-primary);
          font-weight:600;
        }

        /* ── Hero ownership row ── */
        .hero-row {
          display:grid;
          grid-template-columns: repeat(2, minmax(220px, 1fr));
          gap:14px 20px;
          margin-top:16px;
        }
        .quick-item.important.hero {
          padding:20px 18px;
          border-color: rgba(212,175,55,.58);
          background:
            radial-gradient(circle at top right, rgba(212,175,55,.22), rgba(0,0,0,.48));
          box-shadow:
            0 18px 48px rgba(0,0,0,.60),
            0 0 32px rgba(212,175,55,.18);
        }
        .quick-item.important.hero .k {
          font-size: calc(12px * var(--fs-scale));
          color: var(--gold-pale);
          margin-bottom:8px;
        }
        .quick-item.important.hero .v {
          font-size: calc(24px * var(--fs-scale));
          letter-spacing:.02em;
          color:var(--gold-bright);
        }
        /* Share progress bar inside hero items */
        .share-bar-wrap {
          margin-top:10px;
          height:4px;
          background:rgba(212,175,55,.12);
          border-radius:999px;
          overflow:hidden;
        }
        .share-bar-fill {
          height:100%;
          background:linear-gradient(to left, var(--gold-deep), var(--gold-bright));
          border-radius:999px;
          transition:width .6s ease;
        }

        /* ── Big section title (أ, ب headings) ── */
        .big-section-title {
          display:flex;
          align-items:center;
          justify-content:space-between;
          gap:12px;
          margin-bottom:14px;
          padding-bottom:12px;
          border-bottom:1px solid rgba(212,175,55,.16);
        }
        .big-section-title .t {
          font-family: var(--font-ui);
          color: var(--gold-light);
          letter-spacing:.06em;
          font-size: calc(14px * var(--fs-scale));
          font-weight:700;
          display:flex;
          align-items:center;
          gap:8px;
        }
        .section-num {
          display:inline-flex;
          align-items:center;
          justify-content:center;
          width:26px;
          height:26px;
          border-radius:50%;
          background:linear-gradient(135deg,var(--gold-deep),var(--gold-mid));
          color:#0A0A0A;
          font-size:calc(11px * var(--fs-scale));
          font-weight:900;
          flex-shrink:0;
        }
        .big-section-title .s {
          font-size: calc(12px * var(--fs-scale));
          color: var(--text-muted);
        }

        /* ── Subsections ── */
        .subsection {
          margin-top:16px;
          padding-top:14px;
          border-top:1px dashed rgba(212,175,55,.14);
        }
        .subsection-head {
          display:flex;
          align-items:center;
          justify-content:space-between;
          gap:10px;
          margin-bottom:12px;
        }
        .subsection-head .h {
          font-family: var(--font-ui);
          color: var(--gold-bright);
          font-size: calc(13px * var(--fs-scale));
          font-weight:700;
          display:flex;
          align-items:center;
          gap:7px;
        }
        .subsec-num {
          display:inline-flex;
          align-items:center;
          justify-content:center;
          width:20px;
          height:20px;
          border-radius:50%;
          border:1px solid rgba(212,175,55,.35);
          background:rgba(212,175,55,.08);
          color:var(--gold-bright);
          font-size:calc(9px * var(--fs-scale));
          font-weight:700;
          flex-shrink:0;
        }
        .subsection-head .d {
          color: var(--text-muted);
          font-size: calc(11px * var(--fs-scale));
        }
        .subsection-item {
          border:1px solid rgba(212,175,55,.14);
          border-radius:14px;
          background: rgba(0,0,0,.16);
          margin-top:12px;
          overflow:hidden;
          transition:border-color .18s;
        }
        .subsection-item:hover { border-color:rgba(212,175,55,.26); }
        .subsection-item summary {
          cursor:pointer;
          list-style:none;
          display:flex;
          align-items:center;
          justify-content:space-between;
          gap:10px;
          padding:12px 16px;
          font-family: var(--font-ui);
          color: var(--text-secondary);
          font-size:calc(13px * var(--fs-scale));
          font-weight:600;
          background:rgba(212,175,55,.04);
          transition:background .18s;
        }
        .subsection-item summary:hover { background:rgba(212,175,55,.08); }
        .subsection-item[open] summary { border-bottom:1px solid rgba(212,175,55,.12); }
        .subsection-item summary::-webkit-details-marker { display:none; }
        .summary-arrow {
          width:18px; height:18px;
          border:1px solid rgba(212,175,55,.25);
          border-radius:50%;
          display:inline-flex;
          align-items:center;
          justify-content:center;
          color:var(--gold-mid);
          font-size:10px;
          flex-shrink:0;
          transition:transform .22s ease;
        }
        details[open] .summary-arrow { transform:rotate(90deg); }
        .subsection-body { padding:14px 16px 16px; }
        .pill {
          display:inline-flex;
          align-items:center;
          padding:4px 12px;
          border-radius:999px;
          border:1px solid rgba(212,175,55,.25);
          background: rgba(212,175,55,.08);
          color: var(--gold-light);
          font-size: calc(11px * var(--fs-scale));
          font-family: var(--font-ui);
          font-weight:600;
          white-space:nowrap;
        }
        .empty {
          padding:16px;
          border:1px dashed rgba(212,175,55,.18);
          border-radius:12px;
          background: rgba(0,0,0,.14);
          color: var(--text-muted);
          font-size: calc(12px * var(--fs-scale));
          text-align:center;
        }
        .two-cols {
          display:grid;
          grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
          gap:12px 16px;
        }
        .mini {
          border:1px solid rgba(212,175,55,.12);
          border-radius:13px;
          background: rgba(255,255,255,.025);
          padding:12px 14px;
          transition:border-color .18s;
        }
        .mini:hover { border-color:rgba(212,175,55,.24); }
        .mini.important {
          border-color: rgba(212,175,55,.32);
          background:
            radial-gradient(circle at top, rgba(212,175,55,.12), rgba(0,0,0,.22));
          box-shadow: 0 0 20px rgba(212,175,55,.10);
        }
        .mini.important .mini-title { color: var(--gold-light); }
        .mini.important .mini-value { font-size: calc(15px * var(--fs-scale)); font-weight:700; color:var(--gold-bright); }
        .mini-title {
          font-family: var(--font-ui);
          color: var(--text-muted);
          font-size: calc(11px * var(--fs-scale));
          margin-bottom:7px;
          letter-spacing:.02em;
          text-transform:uppercase;
        }
        .mini-value {
          color: var(--text-primary);
          font-size: calc(14px * var(--fs-scale));
          font-weight:600;
          line-height:1.5;
        }
        .icon-inline {
          display:inline-flex;
          align-items:center;
          justify-content:center;
          margin-left:6px;
          transform: translateY(1px);
        }
        .icon-inline svg {
          width:14px;
          height:14px;
          fill: var(--gold-bright);
          opacity:.95;
          filter: drop-shadow(0 0 8px rgba(212,175,55,.20));
        }
        .value .icon-inline { margin-left:8px; }
        .row-line {
          display:flex;
          align-items:center;
          justify-content:space-between;
          gap:12px;
          padding:12px 14px;
          border:1px solid rgba(212,175,55,.12);
          border-radius:13px;
          background: rgba(0,0,0,.14);
          margin-top:10px;
          transition:border-color .18s;
        }
        .row-line:hover { border-color:rgba(212,175,55,.26); }
        .row-title { font-family: var(--font-ui); color: var(--text-secondary); font-size: calc(13px * var(--fs-scale)); font-weight:600; }
        .row-sub { color: var(--text-muted); font-size: calc(11px * var(--fs-scale)); margin-top:3px; }
        .row-main { display:flex; flex-direction:column; }
        .row-actions { flex-shrink:0; }
        .row-meta { flex-shrink:0; }

        /* ── Divider ── */
        .divider {
          height:1px;
          background:linear-gradient(to left,transparent,rgba(212,175,55,.2),transparent);
          margin:16px 0;
        }

        table.simple {
          width:100%;
          border-collapse:collapse;
          font-size: calc(13px * var(--fs-scale));
        }
        table.simple th,
        table.simple td {
          border:1px solid rgba(212,175,55,.18);
          padding:6px 10px;
          text-align:right;
        }
        table.simple th {
          background: rgba(212,175,55,.09);
          color: var(--gold-light);
          font-weight:600;
          font-family: var(--font-ui);
        }
        table.simple tbody tr:nth-child(even) td { background: rgba(255,255,255,.02); }

        /* Mobile / iPhone popup responsiveness
           Use both viewport width and device width because iOS popup sizing
           can keep the CSS viewport wide even on small screens. */
        @media (max-width: 600px), (max-device-width: 600px),
               (max-width: 1024px) and (orientation: portrait),
               (max-device-width: 1024px) and (orientation: portrait) {
          body {
            padding:14px 12px 24px;
            font-size: calc(15px * var(--fs-scale));
          }
          h1 {
            font-size: calc(20px * var(--fs-scale));
            margin-bottom:14px;
          }
          .toolbar {
            grid-template-columns: 1fr;
            gap: 10px;
            padding: 12px 12px;
          }
          .toolbar-right {
            width: 100%;
            justify-content: flex-start;
          }
          .search-wrapper {
            min-width: 0;
            width: 100%;
          }
          .search-input { font-size: calc(14px * var(--fs-scale)); }
          .field-grid { grid-template-columns: 1fr; }
          .quick-grid,
          .hero-row,
          .two-cols {
            grid-template-columns: 1fr !important;
          }
          .section-card {
            padding:16px 14px 14px;
          }
          .field {
            padding:9px 11px;
          }
        }
      </style>
    </head>
    <body>
      <div class="toolbar">
        <div class="toolbar-left">
          <button class="topbar-btn ghost" onclick="window.close()">
            <span class="btn-icon">↩</span>
            <span>العودة</span>
          </button>
        </div>
        <div class="toolbar-right">
          <div class="search-wrapper">
            <span class="search-icon">🔍</span>
            <input
              type="text"
              class="search-input"
              placeholder="بحث برقم العقار..."
              value="${b.propNo}"
              oninput="this.value = this.value.replace(/[^0-9٠-٩\/\-]/g,'')"
            />
          </div>
          <button class="topbar-btn export" onclick="window.print()">
            <span class="btn-icon">🖨</span>
            <span>PDF</span>
          </button>
          <button class="topbar-btn export" onclick="window.exportPropertyExcel && window.exportPropertyExcel()">
            <span class="btn-icon">
              <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                <rect x="1" y="7" width="2.4" height="7" rx="0.6"></rect>
                <rect x="6.1" y="4" width="2.4" height="10" rx="0.6"></rect>
                <rect x="11.2" y="1" width="2.4" height="13" rx="0.6"></rect>
              </svg>
            </span>
            <span>Excel</span>
          </button>

          <!-- ── Gear / Quick Settings toolbar button ── -->
          <button id="toolbar-qs-btn" type="button"
            aria-label="الإعدادات السريعة" title="الإعدادات السريعة"
            onclick="document.getElementById('cd-qs-fab').classList.toggle('open')">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
              stroke="currentColor" stroke-width="1.65">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
          </button>
        </div>
      </div>
      <h1>${b.name} <span>— بطاقة التفاصيل</span>
        ${detailPropId ? `<span class="prop-id-tag">${detailPropId}</span>` : ''}
        <span class="prop-id-tag">رقم العقار ${b.propNo || '—'}</span>
        ${operationalStatusBadge(b.operationalStatus)}
        ${b.status ? `<span class="status-badge ${/مملوك|ملكية كاملة|owned/i.test(b.status) ? 'owned' : /جزئي|partial|مشترك/i.test(b.status) ? 'partial' : 'other'}">${b.status}</span>` : ''}
      </h1>

      <div class="sections">
        <div class="section-card">
          <div class="big-section-title">
            <div class="t"><span class="section-num">أ</span> نبذة سريعة</div>
            <div class="s">البطاقة مرتبطة بتقرير الملاك والإشارات والملحقات</div>
          </div>
          <div class="quick-grid">
            <div class="quick-item important">
              <div class="k">رقم العقار / اسم المحضر</div>
              <div class="v">${b.propNo || '—'}<br/><span style="opacity:.85;font-size:calc(12px * var(--fs-scale))">${b.mahder || '—'}</span></div>
            </div>
            <div class="quick-item">
              <div class="k">الدولة</div>
              <div class="v">${getCountryOfBuilding(b)}</div>
            </div>
            <div class="quick-item">
              <div class="k">المحافظة</div>
              <div class="v">${b.city || '-'}</div>
            </div>
            <div class="quick-item">
              <div class="k">فئة / نوع العقار</div>
              <div class="v">${detailPropKind}</div>
            </div>
            <div class="quick-item">
              <div class="k">تاريخ تملك العقار</div>
              <div class="v">${b.ownDate || '—'}</div>
            </div>
            <div class="quick-item">
              <div class="k">${areaLabelForCard()}</div>
              <div class="v">${typeof b.area === 'number' ? formatAreaFromM2(b.area) : '-'}</div>
            </div>
            <div class="quick-item important">
              <div class="k">الحالة التشغيلية</div>
              <div class="v">${operationalStatusBadge(b.operationalStatus)}</div>
            </div>
            <div class="quick-item">
              <div class="k">الدفعات المالية</div>
              <div class="v">${escapeCellHtml(b.paymentFinanceStatus || '—')}</div>
            </div>
            <div class="quick-item important">
              <div class="k">السعر التقريبي (USD)</div>
              <div class="v">${isFinite(detailApproxUsd) ? formatUsdMoney(detailApproxUsd) : '—'}</div>
            </div>
            <div class="quick-item important">
              <div class="k">السعر الفعلي (USD)</div>
              <div class="v">${isFinite(detailActualUsd) ? formatUsdMoney(detailActualUsd) : (valueUsd != null ? formatUsdMoney(valueUsd) : '—')}</div>
            </div>
            <div class="quick-item">
              <div class="k">المدخل</div>
              <div class="v">${escapeCellHtml(getEnteredByOfBuilding(b, detailBi))}</div>
            </div>
            <div class="quick-item">
              <div class="k">تاريخ الإدخال / آخر تعديل</div>
              <div class="v">${escapeCellHtml(detailCreated)}<br/><span style="opacity:.85">${escapeCellHtml(b.updatedAt || '')}</span></div>
            </div>
          </div>
          ${detailHeroStakesHtml}
        </div>

        <div class="section-card">
          <div class="big-section-title">
            <div class="t"><span class="section-num">ب</span> المعلومات المفصلة</div>
            <div class="s">تنظيم كامل للبيانات (يدعم التكرار)</div>
          </div>

          <div class="subsection">
            <div class="subsection-head">
              <div class="h"><span class="subsec-num">١</span> البيانات الأساسية</div>
              <div class="d">معرّف، موقع، تصنيف، خريطة، ملاحظات، مالية</div>
            </div>
            <div class="field-grid">
              <div class="field"><span class="label">ID العقار</span><span class="value">${detailPropId ? `${icon.doc}${escapeCellHtml(detailPropId)}` : '—'}</span></div>
              <div class="field"><span class="label">الدولة</span><span class="value">${getCountryOfBuilding(b)}</span></div>
              <div class="field"><span class="label">المحافظة</span><span class="value">${b.city || '-'}</span></div>
              <div class="field"><span class="label">المنطقة العقارية (حي/منطقة)</span><span class="value">${b.type || '-'}</span></div>
              <div class="field"><span class="label">رقم العقار / المحضر</span><span class="value">${b.propNo || '—'} / ${b.mahder || '—'}</span></div>
              <div class="field"><span class="label">المقسم</span><span class="value">${b.division || '-'}</span></div>
              <div class="field"><span class="label">فئة / نوع العقار</span><span class="value">${detailPropKind}</span></div>
              <div class="field"><span class="label">تاريخ تملك العقار</span><span class="value">${b.ownDate ? `${icon.cal}${b.ownDate}` : '—'}</span></div>
              <div class="field"><span class="label">الحالة التشغيلية</span><span class="value">${operationalStatusBadge(b.operationalStatus)}</span></div>
              <div class="field"><span class="label">حالة السجل الداخلية</span><span class="value">${b.status || '-'}</span></div>
              <div class="field"><span class="label">نوع الاستثمار</span><span class="value">${b.investType || '-'}</span></div>
              <div class="field"><span class="label">مساحة العقار</span><span class="value">${typeof b.area === 'number' ? `${icon.share}${formatAreaFromM2(b.area)}` : '-'}</span></div>
              <div class="field"><span class="label">السعر التقريبي (USD)</span><span class="value">${isFinite(detailApproxUsd) ? `${icon.money}${formatUsdMoney(detailApproxUsd)}` : '—'}</span></div>
              <div class="field"><span class="label">السعر الفعلي (USD)</span><span class="value">${isFinite(detailActualUsd) ? `${icon.money}${formatUsdMoney(detailActualUsd)}` : (valueUsd != null ? `${icon.money}${formatUsdMoney(valueUsd)}` : '—')}</span></div>
              <div class="field"><span class="label">الدفعات المالية</span><span class="value">${escapeCellHtml(b.paymentFinanceStatus || '—')}</span></div>
              <div class="field"><span class="label">تفاصيل الدفع</span><span class="value">${escapeCellHtml(b.paymentDetailBlurb || b.payments || '—')}</span></div>
              <div class="field"><span class="label">الباقي من الدفعات</span><span class="value">${escapeCellHtml(String(b.paymentRemainderLabel || '—'))}</span></div>
              <div class="field"><span class="label">المدخل</span><span class="value">${escapeCellHtml(getEnteredByOfBuilding(b, detailBi))}</span></div>
              <div class="field"><span class="label">تاريخ الإدخال</span><span class="value">${escapeCellHtml(detailCreated)}</span></div>
              <div class="field"><span class="label">آخر تعديل</span><span class="value">${escapeCellHtml(b.updatedAt || '—')}</span></div>
            </div>
            <div class="field-full" style="margin-top:14px;">
              <span class="label">الموقع الجغرافي (خرائط Google)</span>
              ${detailMapBlockHtml}
            </div>
            <div class="field-full" style="margin-top:12px;">
              <span class="label">ملاحظات عن العقار</span>
              <span class="value" style="white-space:pre-wrap">${escapeCellHtml(b.details || 'لا توجد ملاحظات نصية.')}</span>
            </div>
            <div class="field-full" style="margin-top:14px;">
              <span class="label">إشارات مرتبطة بهذا العقار (${detailSigAux.length})</span>
              <div class="value" style="margin-top:8px">${detailSigAux.length ? detailSigAux.map(s => `<div style="margin-bottom:6px;padding:8px;border-radius:8px;border:1px solid rgba(212,175,55,.12)"><strong>${escapeCellHtml(s.signalId)}</strong> — ${escapeCellHtml(s.signalContractNo)} — ${escapeCellHtml(s.signalType)}</div>`).join('') : 'لا توجد إشارات في تقرير الإشارات.'}</div>
            </div>
            <div class="field-full" style="margin-top:10px;">
              <span class="label">ملحقات مرتبطة (${detailAttAux.length})</span>
              <div class="value" style="margin-top:8px">${detailAttAux.length ? detailAttAux.map(a => `<div style="margin-bottom:4px">${escapeCellHtml(a.attachmentId)} — ${escapeCellHtml(a.attachmentName)}</div>`).join('') : 'لا توجد ملحقات في تقرير الملحقات.'}</div>
            </div>
          </div>

          <div class="subsection">
            <div class="subsection-head">
              <div class="h"><span class="subsec-num">٢</span> ملخص العمليات والأسهم المرجعية</div>
              <div class="d">التفاصيل القانونية الكاملة تظهر أسفله؛ حصص الملاك في قسم النبذة</div>
            </div>
            <div class="two-cols">
              <div class="mini">
                <div class="mini-title">عدد عمليات السجل القديم</div>
                <div class="mini-value">${operations.length ? operations.length.toLocaleString('ar-SA') + ' عملية' : '—'}</div>
              </div>
              <div class="mini">
                <div class="mini-title">إجمالي أسهم مسجَّلة بالعمليات (إن وجد)</div>
                <div class="mini-value">${typeof b.totalOpShares === 'number' ? b.totalOpShares.toLocaleString('ar-SA') : '—'}</div>
              </div>
              <div class="mini important">
                <div class="mini-title">حصة المرجع ٢٤٠٠ (عبد القادر) — ترقية ذاكرة قديمة</div>
                <div class="mini-value">${b.shares?.abdulqader != null ? formatShareOutOf2400(b.shares.abdulqader) : '—'}</div>
              </div>
              <div class="mini important">
                <div class="mini-title">حصة المرجع ٢٤٠٠ (رياض عسلي) — ترقية ذاكرة قديمة</div>
                <div class="mini-value">${b.shares?.riyad != null ? formatShareOutOf2400(b.shares.riyad) : '—'}</div>
              </div>
            </div>
          </div>

          <div class="subsection">
            <div class="subsection-head">
              <div class="h"><span class="subsec-num">٣</span> عمليات العقار</div>
              <div class="d">يدعم أكثر من عملية</div>
            </div>
            ${opsHtml}
          </div>

          <div class="subsection">
            <div class="subsection-head">
              <div class="h"><span class="subsec-num">٤</span> الإشارات</div>
              <div class="d">يدعم أكثر من إشارة</div>
            </div>
            ${signalsCombinedHtml}
          </div>

          <div class="subsection">
            <div class="subsection-head">
              <div class="h"><span class="subsec-num">٥</span> الدفعات</div>
              <div class="d">يدعم أكثر من دفعة</div>
            </div>
            <div class="two-cols">
              <div class="mini">
                <div class="mini-title">قيمة العقار المملوكة بالدولار</div>
                <div class="mini-value">${b.ownedValueUsd ?? '—'}</div>
              </div>
              <div class="mini">
                <div class="mini-title">مجموع الدفعات</div>
                <div class="mini-value">${b.totalPaymentsUsd ?? '—'}</div>
              </div>
              <div class="mini">
                <div class="mini-title">المتبقي</div>
                <div class="mini-value">${b.remainingUsd ?? '—'}</div>
              </div>
            </div>
            ${paymentsHtml}
          </div>

          <div class="subsection">
            <div class="subsection-head">
              <div class="h"><span class="subsec-num">٦</span> ملحقات البطاقة</div>
              <div class="d">يدعم أكثر من ملف</div>
            </div>
            ${attachmentsCombinedHtml}
          </div>
        </div>
      </div>

      <!-- ══════════════════════════════════════════
           لوحة الإعدادات السريعة — نسخة بطاقة التفاصيل
           ══════════════════════════════════════════ -->
      <style>
        /* ── FAB wrapper ── */
        #cd-qs-fab {
          position: fixed;
          z-index: 9999;
          inset-inline-end: max(18px, env(safe-area-inset-right, 0px));
          bottom: max(22px, env(safe-area-inset-bottom, 0px));
          display: flex;
          flex-direction: column;
          align-items: flex-end;
          gap: 10px;
        }
        /* ── Trigger button ── */
        #cd-qs-trigger {
          width: 50px; height: 50px;
          border-radius: 14px;
          border: 1px solid rgba(212,175,55,.42);
          background: linear-gradient(145deg, rgba(22,22,22,.96), rgba(10,10,10,.90));
          color: var(--gold-bright);
          cursor: pointer;
          display: flex; align-items: center; justify-content: center;
          box-shadow: 0 6px 24px rgba(0,0,0,.55), 0 0 18px rgba(212,175,55,.12);
          transition: transform .2s, border-color .2s, box-shadow .2s;
          -webkit-tap-highlight-color: transparent;
          flex-shrink: 0;
        }
        #cd-qs-trigger:hover {
          transform: scale(1.07);
          border-color: rgba(212,175,55,.65);
          box-shadow: 0 8px 28px rgba(0,0,0,.6), 0 0 22px rgba(212,175,55,.18);
        }
        #cd-qs-trigger svg { width: 22px; height: 22px; }
        #cd-qs-fab.open #cd-qs-trigger {
          border-color: rgba(212,175,55,.6);
          box-shadow: 0 0 0 3px rgba(212,175,55,.22);
        }
        /* ── Panel ── */
        #cd-qs-panel {
          display: none;
          width: min(310px, calc(100vw - 36px));
          max-height: min(78vh, 560px);
          overflow-y: auto;
          border-radius: 18px;
          border: 1px solid rgba(212,175,55,.22);
          background: rgba(18,14,28,.97);
          box-shadow: 0 16px 52px rgba(0,0,0,.70), 0 0 28px rgba(212,175,55,.10);
          padding: 0;
          animation: cdQsPop .22s cubic-bezier(.34,1.36,.64,1);
          scrollbar-width: thin;
          scrollbar-color: rgba(212,175,55,.25) transparent;
        }
        #cd-qs-fab.open #cd-qs-panel { display: block; }
        @keyframes cdQsPop {
          from { opacity:0; transform: translateY(10px) scale(.96); }
          to   { opacity:1; transform: translateY(0)   scale(1); }
        }
        /* ── Panel head ── */
        .cd-ph {
          padding: 14px 16px;
          border-bottom: 1px solid rgba(212,175,55,.14);
          display: flex; align-items: center; justify-content: space-between; gap: 10px;
          position: sticky; top: 0;
          background: rgba(14,10,22,.98);
          border-radius: 18px 18px 0 0;
          z-index: 1;
        }
        .cd-ph-title { font-family: var(--font-ui); font-size: 13px; font-weight:700; color: var(--gold-light); }
        .cd-ph-sub   { font-size: 10px; color: var(--text-muted); margin-top: 2px; }
        .cd-ph-close {
          width:30px; height:30px; border-radius:8px;
          border: 1px solid rgba(212,175,55,.22);
          background: rgba(212,175,55,.07);
          color: var(--gold-mid); cursor:pointer;
          display:flex; align-items:center; justify-content:center;
          transition: all .18s; flex-shrink:0;
        }
        .cd-ph-close:hover { border-color:rgba(212,175,55,.45); color:var(--gold-bright); }
        /* ── Panel body ── */
        .cd-pb {
          padding: 12px 14px 16px;
          display: grid; grid-template-columns: 1fr 1fr; gap: 9px;
        }
        /* ── Row ── */
        .cd-row {
          background: rgba(212,175,55,.04);
          border: 1px solid rgba(212,175,55,.12);
          border-radius: 12px;
          padding: 10px 12px;
        }
        .cd-row.span2 { grid-column: 1 / -1; }
        .cd-row-title {
          font-family: var(--font-ui);
          font-size: 10px; color: var(--text-muted);
          display:flex; align-items:center; gap:5px;
          margin-bottom: 8px;
        }
        .cd-row-title svg { width:12px; height:12px; color:var(--gold-mid); flex-shrink:0; }
        /* ── Pill toggle ── */
        .cd-pill {
          display:flex; border-radius:20px; overflow:hidden;
          border:1px solid rgba(212,175,55,.2);
          background: rgba(0,0,0,.18);
        }
        .cd-pill-btn {
          flex:1; padding: 5px 7px;
          font-family: var(--font-ui); font-size: 10px;
          cursor:pointer; background:transparent; border:none;
          color: var(--text-primary); transition: all .18s; white-space:nowrap;
        }
        .cd-pill-btn.active {
          background: linear-gradient(135deg, #8B6914, #C49A2A);
          color: #0A0A0A; font-weight:700;
        }
        /* ── Color grid ── */
        .cd-col-grid {
          display:grid; grid-template-columns: repeat(3, 1fr); gap:5px; margin-top:2px;
        }
        .cd-col-btn {
          border: 1px solid rgba(212,175,55,.18);
          border-radius: 8px;
          background: rgba(255,255,255,.02);
          color: var(--text-muted);
          font-family: var(--font-ui); font-size: 10px;
          padding: 7px 4px; cursor:pointer; transition: all .18s; text-align:center;
        }
        .cd-col-btn:hover { border-color: rgba(212,175,55,.38); color:var(--text-primary); }
        .cd-col-btn.active {
          background: linear-gradient(135deg, #8B6914, #C49A2A);
          color: #0A0A0A; font-weight:700; border-color: transparent;
        }
        /* ── Note ── */
        .cd-note {
          font-size: 9px; color: var(--text-muted); margin-top: 5px; line-height:1.5;
        }
        /* ── Reset btn ── */
        .cd-reset {
          display:inline-flex; align-items:center; gap:4px;
          padding: 5px 10px; border-radius:7px;
          border: 1px solid rgba(212,175,55,.22);
          background: rgba(212,175,55,.06);
          color: var(--text-muted); font-family: var(--font-ui); font-size: 9px;
          cursor:pointer; transition: all .18s; white-space:nowrap;
        }
        .cd-reset:hover { background: rgba(212,175,55,.14); border-color:rgba(212,175,55,.4); color:var(--gold-bright); }
        /* ── Font opts ── */
        .cd-font-opts { display:grid; grid-template-columns: repeat(3,1fr); gap:5px; margin-top:2px; }
        .cd-font-opt {
          display:flex; align-items:center; gap:5px;
          padding: 6px 7px; border-radius:8px; cursor:pointer;
          border:1px solid transparent; transition: all .18s;
        }
        .cd-font-opt input { display:none; }
        .cd-font-radio {
          width:11px; height:11px; border-radius:50%;
          border:2px solid rgba(212,175,55,.3); flex-shrink:0;
          display:flex; align-items:center; justify-content:center;
        }
        .cd-font-opt input:checked ~ .cd-font-radio {
          border-color: var(--gold-bright); background: var(--gold-bright);
        }
        .cd-font-opt input:checked ~ .cd-font-radio::after {
          content:''; width:3px; height:3px; border-radius:50%; background:#0A0A0A;
        }
        .cd-font-opt:has(input:checked) { background: rgba(212,175,55,.08); border-color: rgba(212,175,55,.22); }
        .cd-font-text { display:flex; flex-direction:column; min-width:0; }
        .cd-font-lbl { font-size:10px; color:var(--text-muted); line-height:1.15; }
        .cd-font-sub { font-size:8px; color:var(--text-muted); opacity:.7; }
        /* ── Reload notice ── */
        #cd-reload-bar {
          display:none; position:fixed; top:0; left:0; right:0; z-index:10000;
          background: linear-gradient(135deg, rgba(139,105,20,.95), rgba(196,154,42,.92));
          color: #0A0A0A; padding: 10px 18px;
          font-family: var(--font-ui); font-size:13px; font-weight:700;
          display:flex; align-items:center; justify-content:space-between; gap:12px;
          box-shadow: 0 4px 18px rgba(0,0,0,.45);
        }
        #cd-reload-bar button {
          padding:6px 16px; border-radius:8px;
          background:#0A0A0A; border:none; color:var(--gold-bright);
          font-family:var(--font-ui); font-size:12px; font-weight:700; cursor:pointer;
        }
        @media (max-width:480px) {
          .cd-pb { grid-template-columns: 1fr; }
          .cd-pill { flex-wrap:wrap; }
        }
      </style>

      <!-- FAB HTML -->
      <div id="cd-qs-fab">
        <div id="cd-qs-panel" onclick="event.stopPropagation()">
          <div class="cd-ph">
            <div>
              <div class="cd-ph-title">⚙ الإعدادات السريعة</div>
              <div class="cd-ph-sub">تُطبَّق فوراً على البطاقة</div>
            </div>
            <div style="display:flex;align-items:center;gap:6px">
              <button class="cd-reset" id="cd-reset-btn">↺ افتراضي</button>
              <button class="cd-ph-close" id="cd-ph-close">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2" width="15" height="15">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
              </button>
            </div>
          </div>
          <div class="cd-pb">

            <!-- المظهر -->
            <div class="cd-row">
              <div class="cd-row-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="4"/><path stroke-linecap="round" d="M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                المظهر
              </div>
              <div class="cd-pill">
                <button class="cd-pill-btn" id="cd-theme-dark" onclick="cdSetTheme('dark')">🌙 داكن</button>
                <button class="cd-pill-btn" id="cd-theme-light" onclick="cdSetTheme('light')">☀️ فاتح</button>
              </div>
            </div>

            <!-- حجم الخط -->
            <div class="cd-row">
              <div class="cd-row-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M7.5 8.25h9m-9 3H12"/></svg>
                حجم الخط
              </div>
              <div class="cd-pill">
                <button class="cd-pill-btn" id="cd-fs-normal" onclick="cdSetFs('normal')">١٥</button>
                <button class="cd-pill-btn" id="cd-fs-large"  onclick="cdSetFs('large')">١٧</button>
                <button class="cd-pill-btn" id="cd-fs-xl"     onclick="cdSetFs('xl')">٢٠</button>
                <button class="cd-pill-btn" id="cd-fs-xxl"    onclick="cdSetFs('xxl')">٢٢</button>
              </div>
            </div>

            <!-- العملة -->
            <div class="cd-row span2">
              <div class="cd-row-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
                العملة
              </div>
              <div class="cd-pill">
                <button class="cd-pill-btn" id="cd-cur-usd" onclick="cdSetCurrency('USD')">$ دولار</button>
                <button class="cd-pill-btn" id="cd-cur-lbp" onclick="cdSetCurrency('LBP')">ليرة سورية</button>
                <button class="cd-pill-btn" id="cd-cur-aed" onclick="cdSetCurrency('AED')">درهم إماراتي</button>
              </div>
            </div>

            <!-- المساحة -->
            <div class="cd-row">
              <div class="cd-row-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"/></svg>
                المساحة
              </div>
              <div class="cd-pill">
                <button class="cd-pill-btn" id="cd-area-m2"  onclick="cdSetArea('m2')">م²</button>
                <button class="cd-pill-btn" id="cd-area-ft2" onclick="cdSetArea('ft2')">قدم²</button>
              </div>
            </div>

            <!-- معيار التملك -->
            <div class="cd-row">
              <div class="cd-row-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-6.75A1.125 1.125 0 0 0 7.5 15.375V18.75"/></svg>
                التملك
              </div>
              <div class="cd-pill">
                <button class="cd-pill-btn" id="cd-own-sahm" onclick="cdSetOwnership('sahm')">سهم/2400</button>
                <button class="cd-pill-btn" id="cd-own-pct"  onclick="cdSetOwnership('pct')">نسبة%</button>
              </div>
            </div>

            <!-- لون اللوحة -->
            <div class="cd-row span2">
              <div class="cd-row-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42"/></svg>
                لون اللوحة
              </div>
              <div class="cd-col-grid">
                <button class="cd-col-btn" id="cd-pc-default" onclick="cdSetPanelColor('default')">افتراضي</button>
                <button class="cd-col-btn" id="cd-pc-plum"    onclick="cdSetPanelColor('plum')">برقوقي</button>
                <button class="cd-col-btn" id="cd-pc-slate"   onclick="cdSetPanelColor('slate')">أردوازي</button>
                <button class="cd-col-btn" id="cd-pc-navy"    onclick="cdSetPanelColor('navy')">نيلي</button>
                <button class="cd-col-btn" id="cd-pc-forest"  onclick="cdSetPanelColor('forest')">غابي</button>
                <button class="cd-col-btn" id="cd-pc-stone"   onclick="cdSetPanelColor('stone')">حجري</button>
                <button class="cd-col-btn" id="cd-pc-rose"    onclick="cdSetPanelColor('rose')">وردي</button>
                <button class="cd-col-btn" id="cd-pc-teal"    onclick="cdSetPanelColor('teal')">فيروزي</button>
                <button class="cd-col-btn" id="cd-pc-gold"    onclick="cdSetPanelColor('gold')">ذهبي</button>
              </div>
            </div>

            <!-- لون الخط -->
            <div class="cd-row span2">
              <div class="cd-row-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M12 3v18m9-9H3"/></svg>
                لون الخط
              </div>
              <div class="cd-col-grid">
                <button class="cd-col-btn" id="cd-fc-default" onclick="cdSetFontColor('default')">افتراضي</button>
                <button class="cd-col-btn" id="cd-fc-ivory"   onclick="cdSetFontColor('ivory')">عاجي</button>
                <button class="cd-col-btn" id="cd-fc-gold"    onclick="cdSetFontColor('gold')">ذهبي</button>
                <button class="cd-col-btn" id="cd-fc-silver"  onclick="cdSetFontColor('silver')">فضي</button>
                <button class="cd-col-btn" id="cd-fc-mint"    onclick="cdSetFontColor('mint')">نعناعي</button>
                <button class="cd-col-btn" id="cd-fc-rose"    onclick="cdSetFontColor('rose')">وردي</button>
              </div>
            </div>

            <!-- نوع الخط -->
            <div class="cd-row span2">
              <div class="cd-row-title">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M7.5 8.25h9m-9 3H12"/></svg>
                نوع الخط
              </div>
              <div class="cd-font-opts">
                <label class="cd-font-opt"><input type="radio" name="cd-font" value="Tajawal"><span class="cd-font-radio"></span><span class="cd-font-text"><span class="cd-font-lbl" style="font-family:'Tajawal',sans-serif">Tajawal</span><span class="cd-font-sub">Tajawal</span></span></label>
                <label class="cd-font-opt"><input type="radio" name="cd-font" value="Cairo"><span class="cd-font-radio"></span><span class="cd-font-text"><span class="cd-font-lbl" style="font-family:'Cairo',sans-serif">القاهرة</span><span class="cd-font-sub">Cairo</span></span></label>
                <label class="cd-font-opt"><input type="radio" name="cd-font" value="Amiri"><span class="cd-font-radio"></span><span class="cd-font-text"><span class="cd-font-lbl" style="font-family:'Amiri',serif">أميري</span><span class="cd-font-sub">Amiri</span></span></label>
              </div>
              <div class="cd-note">* تغيير الخط يحتاج إعادة فتح البطاقة ليظهر.</div>
            </div>

          </div><!-- /cd-pb -->
        </div><!-- /cd-qs-panel -->

        <!-- Trigger button -->
        <button id="cd-qs-trigger" aria-label="الإعدادات السريعة">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
          </svg>
        </button>
      </div><!-- /cd-qs-fab -->

      <${''}script>
      (function() {
        'use strict';
        var PREF_KEY = 'realestate_prefs';
        var root = document.documentElement;

        /* ── helpers ── */
        function getP() { try { return JSON.parse(localStorage.getItem(PREF_KEY)) || {}; } catch(e) { return {}; } }
        function saveP(p) { try { localStorage.setItem(PREF_KEY, JSON.stringify(p)); } catch(e) {} }

        /* ── palette maps (mirrors the main page) ── */
        var PANEL_COLORS = {
          default: { dark: { bg:'#1A1A1A', border:'#2A2A2A', head:'#111111' }, light: { bg:'#ffffff', border:'#dfd5c6', head:'#fbf7ee' } },
          plum:    { dark: { bg:'#1E1428', border:'#3E2860', head:'#180F22' }, light: { bg:'#EDE0F8', border:'#C4A0E0', head:'#E0CDF4' } },
          slate:   { dark: { bg:'#1E2530', border:'#3A4558', head:'#1A2030' }, light: { bg:'#EEF2F8', border:'#BCC8DC', head:'#E4EAF4' } },
          navy:    { dark: { bg:'#111A2E', border:'#2A3F6A', head:'#0D1526' }, light: { bg:'#DDE8F8', border:'#96B8E8', head:'#C8D9F4' } },
          forest:  { dark: { bg:'#111E18', border:'#26432E', head:'#0D1A13' }, light: { bg:'#D8F0E0', border:'#88C49A', head:'#C2E6CE' } },
          stone:   { dark: { bg:'#1E1C18', border:'#3D3830', head:'#191712' }, light: { bg:'#EDE8DE', border:'#C0AE90', head:'#E2D9C8' } },
          rose:    { dark: { bg:'#241420', border:'#5C2845', head:'#1C0D19' }, light: { bg:'#F8E4EE', border:'#DDA0BF', head:'#F2D0E4' } },
          teal:    { dark: { bg:'#0F1E20', border:'#1E4A50', head:'#0A1618' }, light: { bg:'#D8F0EE', border:'#80C8C4', head:'#C0E6E4' } },
          gold:    { dark: { bg:'#201A0A', border:'#5A4510', head:'#181200' }, light: { bg:'#FDF3D8', border:'#D4AF5A', head:'#F8E8B8' } }
        };
        var FONT_COLORS = {
          default: { dark: { primary:'#F5F0E8', secondary:'#B0A898', muted:'#6B6560' }, light: { primary:'#2d2418', secondary:'#5e5243', muted:'#7b6f60' } },
          ivory:   { dark: { primary:'#F5F0E8', secondary:'#DCCFB7', muted:'#B6A98E' }, light: { primary:'#2D2418', secondary:'#645845', muted:'#867864' } },
          gold:    { dark: { primary:'#E8C96A', secondary:'#D8B44F', muted:'#A48A46' }, light: { primary:'#7A5B16', secondary:'#9B7522', muted:'#B08A3B' } },
          silver:  { dark: { primary:'#E6EBF2', secondary:'#C6CEDB', muted:'#95A0B2' }, light: { primary:'#2C3748', secondary:'#4C5A6F', muted:'#6B788B' } },
          mint:    { dark: { primary:'#DDF8EE', secondary:'#AEE7D1', muted:'#79B79D' }, light: { primary:'#1E5E4B', secondary:'#2F7861', muted:'#4A9078' } },
          rose:    { dark: { primary:'#F8E5EC', secondary:'#E7BBCB', muted:'#B98297' }, light: { primary:'#6A3245', secondary:'#8A4760', muted:'#A26179' } }
        };
        var FS_MAP = { normal:'15px', large:'17px', xl:'20px', xxl:'22px' };
        var FONT_MAP = {
          Tajawal: "'Tajawal', sans-serif",
          Cairo:   "'Cairo', sans-serif",
          Amiri:   "'Amiri', serif"
        };
        var DEFAULT_RATES = { LBP: 124, AED: 3.67 };

        /* ── apply CSS variables live ── */
        function applyTheme(theme, panelColor, fontColor) {
          var isLight = theme === 'light';
          var bodyBg = isLight ? '#f7f4ee' : '#0A0A0A';
          var pc = PANEL_COLORS[panelColor] || PANEL_COLORS.plum;
          var fc = FONT_COLORS[fontColor] || FONT_COLORS.default;
          var p = pc[isLight ? 'light' : 'dark'];
          var f = fc[isLight ? 'light' : 'dark'];

          root.style.setProperty('--black-pure',   bodyBg);
          root.style.setProperty('--black-rich',   p.head);
          root.style.setProperty('--black-card',   p.bg);
          root.style.setProperty('--black-border', p.border);
          root.style.setProperty('--card-bg',      p.bg);
          root.style.setProperty('--card-border',  p.border);
          root.style.setProperty('--card-head',    p.head);
          root.style.setProperty('--border',       p.border);
          root.style.setProperty('--text-primary',   f.primary);
          root.style.setProperty('--text-secondary', f.secondary);
          root.style.setProperty('--text-muted',     f.muted);
          root.style.setProperty('--ivory-warm',   f.primary);
          root.style.setProperty('--ivory-mid',    f.secondary);
          document.body.style.background = bodyBg;
          document.body.style.color      = f.primary;
        }

        function applyFontSize(fs) {
          var px = FS_MAP[fs] || '15px';
          root.style.setProperty('--fs-base', px);
        }

        function applyFontFamily(ff) {
          var val = FONT_MAP[ff] || FONT_MAP.Tajawal;
          root.style.setProperty('--font-display', val);
          root.style.setProperty('--font-body',    val);
          root.style.setProperty('--font-ui',      val);
        }

        /* ── UI sync ── */
        function setActive(selector, activeId) {
          document.querySelectorAll(selector).forEach(function(el) {
            el.classList.toggle('active', el.id === activeId);
          });
        }
        function syncUI(p) {
          var theme = p.theme || 'dark';
          var fs    = p.fontSize || 'normal';
          var cur   = p.currency || 'USD';
          var area  = p.area || 'm2';
          var own   = p.ownership || 'sahm';
          var pc    = p.panelColor || 'plum';
          var fc    = p.fontColor || 'default';
          var ff    = p.fontFamily || 'Tajawal';

          document.getElementById('cd-theme-dark').classList.toggle('active', theme === 'dark');
          document.getElementById('cd-theme-light').classList.toggle('active', theme === 'light');

          ['normal','large','xl','xxl'].forEach(function(s) {
            document.getElementById('cd-fs-' + s).classList.toggle('active', fs === s);
          });

          document.getElementById('cd-cur-usd').classList.toggle('active', cur === 'USD');
          document.getElementById('cd-cur-lbp').classList.toggle('active', cur === 'LBP');
          document.getElementById('cd-cur-aed').classList.toggle('active', cur === 'AED');

          document.getElementById('cd-area-m2').classList.toggle('active',  area === 'm2');
          document.getElementById('cd-area-ft2').classList.toggle('active', area === 'ft2');

          document.getElementById('cd-own-sahm').classList.toggle('active', own === 'sahm');
          document.getElementById('cd-own-pct').classList.toggle('active',  own === 'pct');

          ['default','plum','slate','navy','forest','stone','rose','teal','gold'].forEach(function(c) {
            document.getElementById('cd-pc-' + c).classList.toggle('active', pc === c);
          });

          ['default','ivory','gold','silver','mint','rose'].forEach(function(c) {
            document.getElementById('cd-fc-' + c).classList.toggle('active', fc === c);
          });

          var radios = document.querySelectorAll('input[name="cd-font"]');
          radios.forEach(function(r) { r.checked = r.value === ff; });
        }

        /* ── public setters ── */
        window.cdSetTheme = function(t) {
          var p = getP(); p.theme = t; saveP(p);
          applyTheme(t, p.panelColor || 'plum', p.fontColor || 'default');
          syncUI(p);
        };
        window.cdSetFs = function(s) {
          var p = getP(); p.fontSize = s; saveP(p);
          applyFontSize(s); syncUI(p);
        };
        window.cdSetCurrency = function(c) {
          var p = getP(); p.currency = c; saveP(p); syncUI(p);
          showReloadBar();
        };
        window.cdSetArea = function(a) {
          var p = getP(); p.area = a; saveP(p); syncUI(p);
          showReloadBar();
        };
        window.cdSetOwnership = function(o) {
          var p = getP(); p.ownership = o; saveP(p); syncUI(p);
          showReloadBar();
        };
        window.cdSetPanelColor = function(c) {
          var p = getP(); p.panelColor = c; saveP(p);
          applyTheme(p.theme || 'dark', c, p.fontColor || 'default');
          syncUI(p);
        };
        window.cdSetFontColor = function(c) {
          var p = getP(); p.fontColor = c; saveP(p);
          applyTheme(p.theme || 'dark', p.panelColor || 'plum', c);
          syncUI(p);
        };

        /* font family — needs page reload to fully apply */
        document.querySelectorAll('input[name="cd-font"]').forEach(function(r) {
          r.addEventListener('change', function() {
            var p = getP(); p.fontFamily = r.value; saveP(p);
            applyFontFamily(r.value);
          });
        });

        /* ── reload bar (for settings that need re-render of data) ── */
        function showReloadBar() {
          var bar = document.getElementById('cd-reload-bar');
          if (bar) bar.style.display = 'flex';
        }
        window.cdReload = function() { location.reload(); };

        /* ── FAB open/close ── */
        var fab   = document.getElementById('cd-qs-fab');
        var panel = document.getElementById('cd-qs-panel');
        document.getElementById('cd-qs-trigger').addEventListener('click', function(e) {
          e.stopPropagation();
          fab.classList.toggle('open');
        });
        document.getElementById('cd-ph-close').addEventListener('click', function() {
          fab.classList.remove('open');
        });
        document.addEventListener('click', function(e) {
          if (!fab.contains(e.target)) fab.classList.remove('open');
        });

        /* ── Reset ── */
        document.getElementById('cd-reset-btn').addEventListener('click', function() {
          var defaults = { theme:'dark', fontSize:'normal', currency:'USD', area:'m2', ownership:'sahm', fontFamily:'Tajawal', panelColor:'plum', fontColor:'default' };
          saveP(defaults);
          applyTheme('dark','plum','default');
          applyFontSize('normal');
          applyFontFamily('Tajawal');
          syncUI(defaults);
          var bar = document.getElementById('cd-reload-bar');
          if (bar) bar.style.display = 'none';
        });

        /* ── Boot: read prefs and apply ── */
        var p0 = getP();
        applyTheme(p0.theme || 'dark', p0.panelColor || 'plum', p0.fontColor || 'default');
        applyFontSize(p0.fontSize || 'normal');
        applyFontFamily(p0.fontFamily || 'Tajawal');
        syncUI(p0);

      })();
      </${''}script>

      <!-- Reload notice bar (hidden until currency/area/ownership changes) -->
      <div id="cd-reload-bar" style="display:none">
        <span>⟳ بعض التغييرات تظهر عند إعادة فتح البطاقة</span>
        <button onclick="cdReload()">إعادة التحميل</button>
      </div>

    </body>
    </html>
  `;

  // On phones, avoid window.open (iOS/Chrome forces it into full-window and breaks layout).
  // Render the same page inside an iframe modal instead.
  if (isPhoneDetails) {
    const modalId = 'property-details-modal';
    const iframeId = 'property-details-iframe';
    const phoneHtml = detailsHtml.replace(/onclick="window\.close\(\)"/g, 'onclick="parent.closePropertyDetailsModal()"');

    let modal = document.getElementById(modalId);
    if (!modal) {
      modal = document.createElement('div');
      modal.id = modalId;
      modal.style.cssText = 'position:fixed;inset:0;z-index:10000;background:rgba(0,0,0,.65);display:none;';
      modal.innerHTML = '<iframe id="' + iframeId + '" style="border:0;width:100%;height:100%;"></iframe>';
      document.body.appendChild(modal);

      // allow closing from the embedded template
      window.closePropertyDetailsModal = function closePropertyDetailsModal() {
        const m = document.getElementById(modalId);
        if (m) m.style.display = 'none';
        document.body.style.overflow = '';
      };

      modal.addEventListener('click', (e) => {
        if (e.target === modal) {
          window.closePropertyDetailsModal();
        }
      });
    }

    const iframe = modal.querySelector('#' + iframeId);
    document.body.style.overflow = 'hidden';
    modal.style.display = 'block';
    iframe.srcdoc = phoneHtml;
    return;
  }

  const w = window.open('', '_blank');
  if (!w) return;
  w.document.write(detailsHtml);

  // تعريف دالة التصدير في نافذة التفاصيل نفسها
  w.exportPropertyExcel = function () {
    const csv = csvText;
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8' });
    const a = w.document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'بيانات_العقار_${b.propNo}.csv';
    a.click();
  };
  w.document.close();
}

function toggleOperations(opsRowId, detailRowId) {
  const opsRow = document.getElementById(opsRowId);
  const detailRow = document.getElementById(detailRowId);
  if (!opsRow) return;
  const isOpen = opsRow.classList.toggle('open');
  if (isOpen && detailRow) {
    detailRow.classList.remove('open');
  }
}

function toggleDetails(rowId, btnId) {
  const row = document.getElementById(rowId);
  const btn = document.getElementById(btnId);
  if (!row || !btn) return;
  const isOpen = row.classList.toggle('open');
  btn.classList.toggle('open', isOpen);
  const arrows = btn.querySelectorAll('span:last-child');
  if (isOpen) {
    btn.lastElementChild.textContent = '▴';
  } else {
    btn.lastElementChild.textContent = '▾';
  }

  // إخفاء صف العمليات في حال فتح تفاصيل العقار
  const idx = rowId.split('-').pop();
  const opsRow = document.getElementById('ops-row-' + idx);
  if (isOpen && opsRow) {
    opsRow.classList.remove('open');
  }
}

const ACTIVITY_LOG_KEY = 'alrowad_activity_v1';

function syncNavForPage(id) {
  const navPageId = (function resolveNavPage() {
    if (id === 'dashboard' || id === 'stats-home' || id === 'stats-generator') return 'stats-home';
    if (id === 'properties' || id === 'owners' || id === 'consultations' || id === 'attachments' || id === 'reports-home') return 'reports-home';
    return id;
  })();
  document.querySelectorAll('[data-nav-page]').forEach(el => {
    const match = el.getAttribute('data-nav-page') === navPageId;
    el.classList.toggle('active', match);
    if (match) el.setAttribute('aria-current', 'page');
    else el.removeAttribute('aria-current');
  });
  document.querySelectorAll('.sidebar-nav .nav-subitem[data-nav-leaf]').forEach(el => {
    el.classList.toggle('active', el.getAttribute('data-nav-leaf') === id);
  });
}

function updateTopbarHubShortcut(pageId) {
  const btn = document.getElementById('topbar-hub-shortcut');
  if (!btn) return;
  const onReports = pageId === 'reports-home' || pageId === 'properties' || pageId === 'owners' || pageId === 'consultations' || pageId === 'attachments';
  const onStats = pageId === 'stats-home' || pageId === 'dashboard' || pageId === 'stats-generator';
  if (onReports) {
    btn.textContent = '⊞ إلى الإحصاءات';
    btn.title = 'الانتقال إلى قسم الإحصاءات';
    btn.onclick = function () { goToPage('stats-home'); };
  } else if (onStats) {
    btn.textContent = '⊞ إلى التقارير';
    btn.title = 'الانتقال إلى قسم التقارير';
    btn.onclick = function () { goToPage('reports-home'); };
  } else {
    btn.textContent = '⊞ إلى التقارير';
    btn.title = 'الانتقال إلى قسم التقارير';
    btn.onclick = function () { goToPage('reports-home'); };
  }
}

const PAGE_TITLES = {
  'stats-home': 'بوابة <span>الإحصاءات</span>',
  'stats-generator': 'مولد <span>الاحصاءات</span>',
  'reports-home': 'بوابة <span>التقارير</span>',
  dashboard: 'ال<span>إحصاءات</span>',
  properties: 'ال<span>تقارير</span>',
  owners: 'تقرير <span>المالك</span>',
  consultations: 'تقرير <span>الإشارات</span>',
  attachments: 'تقرير <span>الملحقات</span>',
  activity: 'تقرير <span>التتبع</span>'
};

const AUX_RECORDS_CONFIG = {
  owners: {
    key: 'owners',
    title: 'تقرير المالك',
    columns: ['ID المالك', 'الاسم والكنية', 'اسم الأب', 'اسم الأم', 'رقم هاتف 1', 'رقم هاتف 2', 'البريد الالكتروني', 'ملاحظات', 'عدد العقارات', 'الإشارات', 'المدخل', 'تاريخ ادخال البيانات', 'تاريخ آخر تعديل'],
    data: [
      { ownerId: 'OWN-001', ownerName: 'أحمد محمد العلي', fatherName: 'محمد', motherName: 'ليلى حسن', phone1: '+963 944 123 456', phone2: '+963 933 987 654', email: 'ahmad.ali@example.com', notesLines: ['يتواصل صباحاً', 'حصة في PRO-001 مع بقية الشركاء'], propertyIds: ['PRO-001'], signalIds: ['SIG-001'], createdAt: '2026-01-08', updatedAt: '2026-02-02', enteredBy: 'سارة' },
      { ownerId: 'OWN-002', ownerName: 'ريم خالد الشامي', fatherName: 'خالد', motherName: 'ميساء عبدو', phone1: '+971 50 123 7788', phone2: '+971 50 7788 9911', email: 'reem.shami@example.com', notesLines: ['مفضّل التواصل واتساب'], propertyIds: ['PRO-003'], signalIds: ['SIG-002'], createdAt: '2026-02-05', updatedAt: '2026-02-07', enteredBy: 'نور' },
      { ownerId: 'OWN-003', ownerName: 'د. عبد القادر السنكري', fatherName: 'عبد القادر', motherName: 'هدى العمر', phone1: '+966 55 100 2200', phone2: '+966 11 200 3300', email: 'sinokri@example.com', notesLines: ['من ملاك برج النخيل التجاري — راجع العمليات في بطاقة العقار'], propertyIds: ['PRO-001'], signalIds: ['SIG-015'], createdAt: '2026-01-09', updatedAt: '2026-02-08', enteredBy: 'خالد' },
      { ownerId: 'OWN-017', ownerName: 'رياض عسلي', fatherName: 'عسلي', motherName: 'فاديا محمود', phone1: '+966 50 441 0099', phone2: '', email: 'riyad.asali@example.com', notesLines: ['شريك في PRO-001 وفق سجل الأسهم'], propertyIds: ['PRO-001'], signalIds: [], createdAt: '2026-01-10', updatedAt: '2026-01-28', enteredBy: 'سارة' },
      { ownerId: 'OWN-018', ownerName: 'عمر الزهراني', fatherName: 'زهير', motherName: 'ناهد سالم', phone1: '+966 54 889 2211', phone2: '', email: '', notesLines: ['شريك ثانوي في PRO-003'], propertyIds: ['PRO-003'], signalIds: [], createdAt: '2026-01-12', updatedAt: '2026-01-30', enteredBy: 'أحمد' },
      { ownerId: 'OWN-019', ownerName: 'هدى المالكي', fatherName: 'عبد الرحمن', motherName: 'سلمى عبدالله', phone1: '+966 55 300 8844', phone2: '+966 12 778 9011', email: '', notesLabels: [], notesLines: ['شريك تشغيلي في مجمع الروضة الفندقي'], propertyIds: ['PRO-013'], signalIds: [], createdAt: '2026-01-14', updatedAt: '2026-02-01', enteredBy: 'ريم' },
      { ownerId: 'OWN-004', ownerName: 'مجموعة مستثمري الواحة', fatherName: '—', motherName: '—', phone1: '+966 12 345 8899', phone2: '+966 12 345 8877', email: 'legal@wahainvest.sa', notesLines: ['صندوق تمثيل جماعي لملاك المجمع'], propertyIds: ['PRO-002'], signalIds: ['SIG-003'], createdAt: '2026-01-11', updatedAt: '2026-02-03', enteredBy: 'خالد' },
      { ownerId: 'OWN-005', ownerName: 'شركة واجهات الخليج', fatherName: '—', motherName: '—', phone1: '+966 13 222 4400', phone2: '', email: 'cases@wajhat.sa', notesLines: ['المرجع القانوني: إدارة العقود'], propertyIds: ['PRO-004'], signalIds: ['SIG-004'], createdAt: '2026-01-14', updatedAt: '2026-02-04', enteredBy: 'ليث' },
      { ownerId: 'OWN-006', ownerName: 'هيئة المحفظة — أبوظبي', fatherName: '—', motherName: '—', phone1: '+971 2 665 4411', phone2: '', email: '', notesLines: ['جهة سيادية — ملفات PDF في الملحقات'], propertyIds: ['PRO-005'], signalIds: ['SIG-005'], createdAt: '2026-01-16', updatedAt: '2026-01-22', enteredBy: 'ريم' },
      { ownerId: 'OWN-007', ownerName: 'شركة بوابة الرياض القابضة', fatherName: '—', motherName: '—', phone1: '+966 11 888 7733', phone2: '+966 11 888 7722', email: '', notesLines: [], propertyIds: ['PRO-006'], signalIds: ['SIG-006'], createdAt: '2026-01-18', updatedAt: '2026-02-05', enteredBy: 'أحمد' },
      { ownerId: 'OWN-008', ownerName: 'شركة مسارات جدة للعقارات', fatherName: '—', motherName: '—', phone1: '+966 12 455 8899', phone2: '', email: '', notesLines: [], propertyIds: ['PRO-007'], signalIds: ['SIG-007'], createdAt: '2026-01-20', updatedAt: '2026-01-29', enteredBy: 'سارة' },
      { ownerId: 'OWN-009', ownerName: 'جمعية ملاك بيوت الشمال', fatherName: '—', motherName: '—', phone1: '+966 11 234 6611', phone2: '', email: '', notesLines: [], propertyIds: ['PRO-008'], signalIds: ['SIG-008'], createdAt: '2026-01-21', updatedAt: '2026-02-06', enteredBy: 'نور' },
      { ownerId: 'OWN-010', ownerName: 'إدارة البرج — دبي', fatherName: '—', motherName: '—', phone1: '+971 4 555 8877', phone2: '', email: '', notesLines: [], propertyIds: ['PRO-009'], signalIds: ['SIG-009'], createdAt: '2026-01-22', updatedAt: '2026-02-06', enteredBy: 'خالد' },
      { ownerId: 'OWN-011', ownerName: 'شركة المنارة الإسكانية', fatherName: '—', motherName: '—', phone1: '+966 13 444 9911', phone2: '', email: '', notesLines: [], propertyIds: ['PRO-010'], signalIds: ['SIG-010'], createdAt: '2026-01-23', updatedAt: '2026-02-06', enteredBy: 'ليث' },
      { ownerId: 'OWN-012', ownerName: 'مكتب الالتزام — أبوظبي', fatherName: '—', motherName: '—', phone1: '+971 2 411 7711', phone2: '', email: '', notesLines: [], propertyIds: ['PRO-011'], signalIds: ['SIG-011'], createdAt: '2026-02-01', updatedAt: '2026-02-07', enteredBy: 'ريم' },
      { ownerId: 'OWN-013', ownerName: 'شركة الواجهات الذهبية', fatherName: '—', motherName: '—', phone1: '+966 12 777 6611', phone2: '', email: '', notesLines: [], propertyIds: ['PRO-012'], signalIds: ['SIG-012'], createdAt: '2026-02-03', updatedAt: '2026-02-08', enteredBy: 'أحمد' },
      { ownerId: 'OWN-014', ownerName: 'شركة تشغيل الروضة الفندقي', fatherName: '—', motherName: '—', phone1: '+966 11 200 8844', phone2: '+966 11 200 8855', email: '', notesLines: [], propertyIds: ['PRO-013'], signalIds: ['SIG-013'], createdAt: '2026-02-04', updatedAt: '2026-02-09', enteredBy: 'سارة' },
      { ownerId: 'OWN-015', ownerName: 'شركة أبراج الخليج دبي', fatherName: '—', motherName: '—', phone1: '+971 4 321 8899', phone2: '', email: '', notesLines: [], propertyIds: ['PRO-014'], signalIds: ['SIG-014'], createdAt: '2026-02-06', updatedAt: '2026-02-10', enteredBy: 'نور' },
      { ownerId: 'OWN-D-201', ownerName: 'شركة التوريد', fatherName: '—', motherName: '—', phone1: '+966 11 900 7766', phone2: '', email: '', notesLines: ['طرف مدعى عليه في SIG-001 — سجل المواد في الملحقات'], propertyIds: [], signalIds: ['SIG-001'], createdAt: '2026-01-09', updatedAt: '2026-01-20', enteredBy: 'سارة' },
      { ownerId: 'OWN-D-202', ownerName: 'مقاول التنفيذ', fatherName: '—', motherName: '—', phone1: '+966 50 661 7722', phone2: '', email: '', notesLines: [], propertyIds: [], signalIds: ['SIG-002'], createdAt: '2026-02-06', updatedAt: '2026-02-07', enteredBy: 'نور' },
      { ownerId: 'OWN-D-203', ownerName: 'شركة إدارة المجمع', fatherName: '—', motherName: '—', phone1: '+966 55 661 9911', phone2: '', email: '', notesLines: [], propertyIds: [], signalIds: ['SIG-003'], createdAt: '2026-01-11', updatedAt: '2026-01-25', enteredBy: 'خالد' },
      { ownerId: 'OWN-D-204', ownerName: 'مشغل الفندق الحالي', fatherName: '—', motherName: '—', phone1: '+966 13 441 7722', phone2: '', email: '', notesLines: [], propertyIds: [], signalIds: ['SIG-004'], createdAt: '2026-01-14', updatedAt: '2026-01-26', enteredBy: 'ليث' },
      { ownerId: 'OWN-D-205', ownerName: 'جهة التمويل', fatherName: '—', motherName: '—', phone1: '+966 11 700 8899', phone2: '', email: '', notesLines: ['محتجز وفق SIG-015'], propertyIds: [], signalIds: ['SIG-015'], createdAt: '2026-02-07', updatedAt: '2026-02-09', enteredBy: 'خالد' },
      { ownerId: 'OWN-D-206', ownerName: 'مستأجر سابق — محل رقم ٤', fatherName: '—', motherName: '—', phone1: '', phone2: '', email: '', notesLines: [], propertyIds: [], signalIds: ['SIG-006'], createdAt: '2026-01-18', updatedAt: '2026-01-30', enteredBy: 'أحمد' },
      { ownerId: 'OWN-D-207', ownerName: 'مقاول واجهات زجاجية', fatherName: '—', motherName: '—', phone1: '+966 54 661 7733', phone2: '', email: '', notesLines: [], propertyIds: [], signalIds: ['SIG-007'], createdAt: '2026-01-20', updatedAt: '2026-02-02', enteredBy: 'سارة' },
      { ownerId: 'OWN-D-208', ownerName: 'البنك الأهلي — إدارة التحصيل', fatherName: '—', motherName: '—', phone1: '+966 800 4400', phone2: '', email: '', notesLines: [], propertyIds: [], signalIds: ['SIG-008'], createdAt: '2026-01-21', updatedAt: '2026-01-29', enteredBy: 'نور' },
      { ownerId: 'OWN-D-209', ownerName: 'شركة تأجير المساحات المشتركة', fatherName: '—', motherName: '—', phone1: '+971 52 661 8844', phone2: '', email: '', notesLines: [], propertyIds: [], signalIds: ['SIG-009'], createdAt: '2026-01-22', updatedAt: '2026-02-03', enteredBy: 'خالد' },
      { ownerId: 'OWN-D-210', ownerName: 'بلدية المنطقة الشرقية', fatherName: '—', motherName: '—', phone1: '+966 13 555 6611', phone2: '', email: '', notesLines: [], propertyIds: [], signalIds: ['SIG-010'], createdAt: '2026-01-23', updatedAt: '2026-02-05', enteredBy: 'ليث' },
      { ownerId: 'OWN-D-211', ownerName: 'شركة تأجير وإدارة وحدات', fatherName: '—', motherName: '—', phone1: '+966 55 773 8844', phone2: '', email: '', notesLines: [], propertyIds: [], signalIds: ['SIG-012'], createdAt: '2026-02-03', updatedAt: '2026-02-06', enteredBy: 'أحمد' },
      { ownerId: 'OWN-D-212', ownerName: 'شركة المرافق الموحَّدة', fatherName: '—', motherName: '—', phone1: '+966 55 884 9933', phone2: '', email: '', notesLines: [], propertyIds: [], signalIds: ['SIG-013'], createdAt: '2026-02-04', updatedAt: '2026-02-07', enteredBy: 'سارة' },
      { ownerId: 'OWN-D-213', ownerName: 'شريك تشغيل دولي — فرع المنطقة', fatherName: '—', motherName: '—', phone1: '+971 4 990 1122', phone2: '', email: '', notesLines: [], propertyIds: [], signalIds: ['SIG-014'], createdAt: '2026-02-06', updatedAt: '2026-02-08', enteredBy: 'نور' }
    ]
  },
  consultations: {
    key: 'consultations',
    title: 'تقرير الإشارات',
    columns: ['ID الاشارة', 'رقم عقد الاشارة', 'نوع الاشارة', 'تاريخ الاشارة', 'ملاحظات الاشارة', 'صاحب الاشارة', 'المدعى عليهم', 'المدخل', 'تاريخ ادخال البيانات', 'تاريخ آخر تعديل'],
    data: [
      { signalId: 'SIG-001', signalContractNo: 'A-10021', signalDate: '2025-03-11', signalType: 'دعوى', notesLines: ['تم تقديم الدعوى لدى المحكمة العقارية.', 'مرتبط بعقار برج النخيل التجاري — بانتظار الجلسة الأولى.'], claimantOwnerIds: ['OWN-001'], defendantOwnerIds: ['OWN-D-201'], propertyIds: ['PRO-001'], attachmentIds: ['ATT-301', 'ATT-302'], fileNames: ['لائحة-دعوى-A10021.pdf', 'تبليغ-محكمة.pdf'], createdAt: '2026-01-09', updatedAt: '2026-02-02', enteredBy: 'سارة' },
      { signalId: 'SIG-002', signalContractNo: 'A-10310', signalDate: '2026-02-03', signalType: 'استيفاء', notesLines: ['تم استيفاء المبلغ وفقاً للتسوية.', 'أُغلقت المعاملة — عقار أبراج المدينة المكتبية.'], claimantOwnerIds: ['OWN-002'], defendantOwnerIds: ['OWN-D-202'], propertyIds: ['PRO-003'], attachmentIds: ['ATT-303'], fileNames: ['إقرار-تسوية.pdf'], createdAt: '2026-02-06', updatedAt: '2026-02-07', enteredBy: 'نور' },
      { signalId: 'SIG-003', signalContractNo: 'A-20660', signalDate: '2025-04-21', signalType: 'تظلم', notesLines: ['إشارة مرتبطة بعقد صيانة المجمع السكني.', 'جارٍ تبادل مذكرات بين الأطراف.'], claimantOwnerIds: ['OWN-004'], defendantOwnerIds: ['OWN-D-203'], propertyIds: ['PRO-002'], attachmentIds: ['ATT-304', 'ATT-305'], fileNames: ['عقد-صيانة.pdf', 'مذكرة-تظلم.docx'], createdAt: '2026-01-11', updatedAt: '2026-02-03', enteredBy: 'خالد' },
      { signalId: 'SIG-004', signalContractNo: 'A-21891', signalDate: '2025-08-03', signalType: 'تنفيذ', notesLines: ['طلب تنفيذ بخصوص مستحقات تشغيل فندقي.', 'المحامي المعتمد لمتابعة الإجراء.'], claimantOwnerIds: ['OWN-005'], defendantOwnerIds: ['OWN-D-204'], propertyIds: ['PRO-004'], attachmentIds: ['ATT-306'], fileNames: ['طلب-تنفيذ.pdf'], createdAt: '2026-01-14', updatedAt: '2026-02-04', enteredBy: 'ليث' },
      { signalId: 'SIG-005', signalContractNo: 'A-22105', signalDate: '2025-06-17', signalType: 'مراجعة', notesLines: ['إشارة إدارية لمراجعة عقود الشركات المتعددة الجنسيات.', 'لا منازعة مالية مسجَّلة بعد.'], claimantOwnerIds: ['OWN-006'], defendantOwnerIds: [], propertyIds: ['PRO-005'], attachmentIds: ['ATT-307'], fileNames: ['جدول-مراجعة.xlsx'], createdAt: '2026-01-16', updatedAt: '2026-01-25', enteredBy: 'ريم' },
      { signalId: 'SIG-006', signalContractNo: 'A-23144', signalDate: '2025-09-09', signalType: 'دعوى', notesLines: ['نزاع على إيقاف أعمال تأجير جزئية.', 'الجلسة المبدئية مُحدَّدة.'], claimantOwnerIds: ['OWN-007'], defendantOwnerIds: ['OWN-D-206'], propertyIds: ['PRO-006'], attachmentIds: ['ATT-308'], fileNames: ['صور-المحل-٤.pdf'], createdAt: '2026-01-18', updatedAt: '2026-02-05', enteredBy: 'أحمد' },
      { signalId: 'SIG-007', signalContractNo: 'A-24008', signalDate: '2025-11-02', signalType: 'صلح', notesLines: ['محاولة صلح قبل رفع الدعوى.', 'تم تمديد مهلة الدفع أسبوعين.'], claimantOwnerIds: ['OWN-008'], defendantOwnerIds: ['OWN-D-207'], propertyIds: ['PRO-007'], attachmentIds: ['ATT-309'], fileNames: ['مسودة-صلح.docx'], createdAt: '2026-01-20', updatedAt: '2026-02-02', enteredBy: 'سارة' },
      { signalId: 'SIG-008', signalContractNo: 'A-25090', signalDate: '2025-05-29', signalType: 'حجز', notesLines: ['حجز على جزء من المجمع وفق تنبيه بنكي.', 'المالكون يتابعون فكّ الحجز.'], claimantOwnerIds: ['OWN-009'], defendantOwnerIds: ['OWN-D-208'], propertyIds: ['PRO-008'], attachmentIds: ['ATT-310'], fileNames: ['تنبيه-بنكي.pdf'], createdAt: '2026-01-21', updatedAt: '2026-02-06', enteredBy: 'نور' },
      { signalId: 'SIG-009', signalContractNo: 'A-26011', signalDate: '2025-10-14', signalType: 'إنذار', notesLines: ['إنذار بسبب تأخر سداد أقساط الخدمات المشتركة.', 'انتظار الرد خطياً خلال ١٥ يوماً.'], claimantOwnerIds: ['OWN-010'], defendantOwnerIds: ['OWN-D-209'], propertyIds: ['PRO-009'], attachmentIds: ['ATT-311'], fileNames: ['إنذار-خطي.pdf'], createdAt: '2026-01-22', updatedAt: '2026-02-05', enteredBy: 'خالد' },
      { signalId: 'SIG-010', signalContractNo: 'A-27033', signalDate: '2025-07-06', signalType: 'مخالفة', notesLines: ['مخالفة بناء مؤقتة في مواقف الزوار.', 'تم سداد الغرامة وإخطار الجهة البلدية.'], claimantOwnerIds: ['OWN-011'], defendantOwnerIds: ['OWN-D-210'], propertyIds: ['PRO-010'], attachmentIds: ['ATT-312'], fileNames: ['قرار-غرامة.pdf'], createdAt: '2026-01-23', updatedAt: '2026-02-06', enteredBy: 'ليث' },
      { signalId: 'SIG-011', signalContractNo: 'A-28077', signalDate: '2025-12-01', signalType: 'تدقيق', notesLines: ['تدقيق داخلي لعقود الإيجار المالية بالمركز.', 'لا توقيع على إجراء قضائي.'], claimantOwnerIds: ['OWN-012'], defendantOwnerIds: [], propertyIds: ['PRO-011'], attachmentIds: ['ATT-313'], fileNames: ['مرفقات-تدقيق.zip'], createdAt: '2026-02-01', updatedAt: '2026-02-07', enteredBy: 'ريم' },
      { signalId: 'SIG-012', signalContractNo: 'A-29120', signalDate: '2025-03-08', signalType: 'دعوى', notesLines: ['دعوى بسبب تأخر تسليم وحدات مؤجَّرة سياحياً.', 'المرافعة الأولى تمت وراء الأبواب.'], claimantOwnerIds: ['OWN-013'], defendantOwnerIds: ['OWN-D-211'], propertyIds: ['PRO-012'], attachmentIds: ['ATT-314'], fileNames: ['محضر-جلسة.pdf'], createdAt: '2026-02-03', updatedAt: '2026-02-07', enteredBy: 'أحمد' },
      { signalId: 'SIG-013', signalContractNo: 'A-30005', signalDate: '2025-06-26', signalType: 'استيفاء جزئي', notesLines: ['سداد جزء من رسوم الطاقة المتأخرة.', 'خطة تقسيط لباقي المبلغ تحت المراجعة.'], claimantOwnerIds: ['OWN-014', 'OWN-019'], defendantOwnerIds: ['OWN-D-212'], propertyIds: ['PRO-013'], attachmentIds: ['ATT-315'], fileNames: ['إيصال-استيفاء-جزئي.pdf'], createdAt: '2026-02-04', updatedAt: '2026-02-08', enteredBy: 'سارة' },
      { signalId: 'SIG-014', signalContractNo: 'A-31088', signalDate: '2025-11-19', signalType: 'تحكيم', notesLines: ['اتفاق على التحكيم لحسم نسب إيرادات الإيجار.', 'تم تعيين محكم واحد مرضٍ للطرفين.'], claimantOwnerIds: ['OWN-015'], defendantOwnerIds: ['OWN-D-213'], propertyIds: ['PRO-014'], attachmentIds: ['ATT-316'], fileNames: ['اتفاق-تحكيم.pdf'], createdAt: '2026-02-06', updatedAt: '2026-02-09', enteredBy: 'نور' },
      { signalId: 'SIG-015', signalContractNo: 'A-30150', signalDate: '2025-01-20', signalType: 'حجز', notesLines: ['حجز تحفظي مؤقت على حصص مرتبطة ببرج النخيل.', 'متابعة وحدة القانون لاستكمال الإجراء الإداري.'], claimantOwnerIds: ['OWN-003'], defendantOwnerIds: ['OWN-D-205'], propertyIds: ['PRO-001'], attachmentIds: ['ATT-317', 'ATT-301'], fileNames: ['قرار-حجز.pdf', 'مستخرج-سجل.pdf'], createdAt: '2026-02-07', updatedAt: '2026-02-09', enteredBy: 'خالد' }
    ]
  },
  attachments: {
    key: 'attachments',
    title: 'تقرير الملحقات',
    columns: ['id الملحق', 'اسم الملحق', 'رقم الملحق', 'تاريخ الملحق', 'تفاصيل', 'زر تنزيل الملحق', 'المدخل', 'تاريخ ادخال البيانات', 'تاريخ آخر تعديل'],
    data: [
      { attachmentId: 'ATT-301', attachmentName: 'مستخرج سجل عقاري — برج النخيل', attachmentNo: 'MJ-8891-R', attachmentDate: '2025-12-18', propertyIds: ['PRO-001'], signalIds: ['SIG-001', 'SIG-015'], downloadName: 'مستخرج-سجل.pdf', summaryLine: 'يخص عقار PRO-001 وإشارات SIG-001 / SIG-015', createdAt: '2026-01-02', updatedAt: '2026-02-01', enteredBy: 'خالد' },
      { attachmentId: 'ATT-302', attachmentName: 'لائحة دعوى عقارية', attachmentNo: 'MJ-8892-R', attachmentDate: '2025-12-05', propertyIds: ['PRO-001'], signalIds: ['SIG-001'], downloadName: 'لائحة-دعوى.pdf', summaryLine: 'مرفق بحوزة OWN-001 وطرف شركة التوريد', createdAt: '2026-01-03', updatedAt: '2026-01-20', enteredBy: 'سارة' },
      { attachmentId: 'ATT-303', attachmentName: 'إقرار تسوية وتسوية مالية', attachmentNo: 'MJ-2109-A', attachmentDate: '2026-02-02', propertyIds: ['PRO-003'], signalIds: ['SIG-002'], downloadName: 'تسوية-10310.pdf', summaryLine: 'عقار PRO-003 — طرف ريم ومقاول التنفيذ', createdAt: '2026-02-05', updatedAt: '2026-02-07', enteredBy: 'نور' },
      { attachmentId: 'ATT-304', attachmentName: 'عقد صيانة المجمع', attachmentNo: 'MJ-4501-W', attachmentDate: '2025-06-01', propertyIds: ['PRO-002'], signalIds: ['SIG-003'], downloadName: 'صيانة-واحة.pdf', summaryLine: 'يربط مجموعة الواحة بإدارة المجمع', createdAt: '2026-01-11', updatedAt: '2026-01-18', enteredBy: 'خالد' },
      { attachmentId: 'ATT-305', attachmentName: 'مذكرة التظلم', attachmentNo: 'MJ-4502-W', attachmentDate: '2025-06-21', propertyIds: ['PRO-002'], signalIds: ['SIG-003'], downloadName: 'تظلم-مذكرة.docx', summaryLine: 'ملحق لنفس مسار ATT-304', createdAt: '2026-01-12', updatedAt: '2026-01-19', enteredBy: 'خالد' },
      { attachmentId: 'ATT-306', attachmentName: 'طلب تنفيذ وفواتير', attachmentNo: 'MJ-7822-F', attachmentDate: '2025-07-29', propertyIds: ['PRO-004'], signalIds: ['SIG-004'], downloadName: 'تنفيذ-21891.pdf', summaryLine: 'فندقي د.مّ — أطراف شركة واجهات الخليج', createdAt: '2026-01-13', updatedAt: '2026-02-04', enteredBy: 'ليث' },
      { attachmentId: 'ATT-307', attachmentName: 'جدول المراجعة الإدارية', attachmentNo: 'MJ-6610-A', attachmentDate: '2025-06-03', propertyIds: ['PRO-005'], signalIds: ['SIG-005'], downloadName: 'مراجعة-22105.xlsx', summaryLine: 'مركز الأعمال الدولي — أبوظبي', createdAt: '2026-01-14', updatedAt: '2026-01-24', enteredBy: 'ريم' },
      { attachmentId: 'ATT-308', attachmentName: 'صور وفيديو محل تجاري', attachmentNo: 'MJ-9931-R', attachmentDate: '2025-10-02', propertyIds: ['PRO-006'], signalIds: ['SIG-006'], downloadName: 'محمد-٢٣١٤٤.zip', summaryLine: 'بوابة الرياض — المحل رقم ٤', createdAt: '2026-01-15', updatedAt: '2026-01-30', enteredBy: 'أحمد' },
      { attachmentId: 'ATT-309', attachmentName: 'مسودة اتفاق صلح', attachmentNo: 'MJ-8840-J', attachmentDate: '2025-11-15', propertyIds: ['PRO-007'], signalIds: ['SIG-007'], downloadName: 'صلح-24008.docx', summaryLine: 'أبراج جدة الإدارية', createdAt: '2026-01-17', updatedAt: '2026-02-01', enteredBy: 'سارة' },
      { attachmentId: 'ATT-310', attachmentName: 'خطاب تنبيه بنكي', attachmentNo: 'MJ-2208-B', attachmentDate: '2025-06-06', propertyIds: ['PRO-008'], signalIds: ['SIG-008'], downloadName: 'تنبيه-بنكي.pdf', summaryLine: 'فيلات بيوت الشمال — حجز', createdAt: '2026-01-18', updatedAt: '2026-01-28', enteredBy: 'نور' },
      { attachmentId: 'ATT-311', attachmentName: 'إشعار خدمات مشتركة', attachmentNo: 'MJ-6612-D', attachmentDate: '2025-09-02', propertyIds: ['PRO-009'], signalIds: ['SIG-009'], downloadName: 'إنذار-26011.pdf', summaryLine: 'مجمع دبي للأعمال', createdAt: '2026-01-19', updatedAt: '2026-02-04', enteredBy: 'خالد' },
      { attachmentId: 'ATT-312', attachmentName: 'قرار غرامة بلدي', attachmentNo: 'MJ-4410-E', attachmentDate: '2025-06-29', propertyIds: ['PRO-010'], signalIds: ['SIG-010'], downloadName: 'غرامة-بلدية.pdf', summaryLine: 'برج المنارة السكني', createdAt: '2026-01-20', updatedAt: '2026-02-06', enteredBy: 'ليث' },
      { attachmentId: 'ATT-313', attachmentName: 'أرشيف تدقيق داخلي', attachmentNo: 'MJ-5521-F', attachmentDate: '2025-11-14', propertyIds: ['PRO-011'], signalIds: ['SIG-011'], downloadName: 'تدقيق-28077.zip', summaryLine: 'مركز أبوظبي المالي', createdAt: '2026-01-21', updatedAt: '2026-02-07', enteredBy: 'ريم' },
      { attachmentId: 'ATT-314', attachmentName: 'محضر جلسة تأجير سياحي', attachmentNo: 'MJ-9933-H', attachmentDate: '2025-06-03', propertyIds: ['PRO-012'], signalIds: ['SIG-012'], downloadName: 'جلسة-29120.pdf', summaryLine: 'الحي الذهبي السكني', createdAt: '2026-01-22', updatedAt: '2026-02-07', enteredBy: 'أحمد' },
      { attachmentId: 'ATT-315', attachmentName: 'إيصال استيفاء طاقة', attachmentNo: 'MJ-8844-P', attachmentDate: '2025-06-27', propertyIds: ['PRO-013'], signalIds: ['SIG-013'], downloadName: 'طاقة-30005.pdf', summaryLine: 'مجمع الروضة الفندقي', createdAt: '2026-01-23', updatedAt: '2026-02-08', enteredBy: 'سارة' },
      { attachmentId: 'ATT-316', attachmentName: 'اتفاق تحكيم وإقرار طرفين', attachmentNo: 'MJ-7743-T', attachmentDate: '2025-11-02', propertyIds: ['PRO-014'], signalIds: ['SIG-014'], downloadName: 'تحكيم-31088.pdf', summaryLine: 'برج الخليج للأعمال', createdAt: '2026-01-24', updatedAt: '2026-02-09', enteredBy: 'نور' },
      { attachmentId: 'ATT-317', attachmentName: 'قرار حجز تحفظي', attachmentNo: 'MJ-9939-K', attachmentDate: '2025-01-18', propertyIds: ['PRO-001'], signalIds: ['SIG-015'], downloadName: 'حجز-30150.pdf', summaryLine: 'حصص في PRO-001 — جهة التمويل', createdAt: '2026-01-25', updatedAt: '2026-02-09', enteredBy: 'خالد' }
    ]
  }
};

const auxRecordStates = {};

/** خريطة سريعة لأسماء الملاك وأطراف الشكاوى بحسب المعرف — تُحمَّل بعد تحديث AUX_RECORDS_CONFIG */
function getAuxOwnerRowMap() {
  const map = {};
  const rows = (AUX_RECORDS_CONFIG.owners && AUX_RECORDS_CONFIG.owners.data) || [];
  rows.forEach(r => { map[r.ownerId] = r; });
  return map;
}

function auxFormatOwnerLabels(ids) {
  const map = getAuxOwnerRowMap();
  return (ids || []).map(id => (map[id] ? map[id].ownerName : id)).filter(Boolean);
}

function lookupBuildingByPropId(propId) {
  return buildings.find(b => b.propId === propId);
}

function auxConsultRowBySigId(sigId) {
  return (AUX_RECORDS_CONFIG.consultations && AUX_RECORDS_CONFIG.consultations.data || []).find(c => c.signalId === sigId);
}

function auxAttachmentRowById(attId) {
  return (AUX_RECORDS_CONFIG.attachments && AUX_RECORDS_CONFIG.attachments.data || []).find(a => a.attachmentId === attId);
}

function propertySignalsFromAux(propId) {
  var rows = [];
  try { rows = AUX_RECORDS_CONFIG.consultations.data || []; } catch (e) {}
  return rows.filter(function (c) { return Array.isArray(c.propertyIds) && c.propertyIds.indexOf(propId) !== -1; });
}

function propertyAttachmentsFromAux(propId) {
  var rows = [];
  try { rows = AUX_RECORDS_CONFIG.attachments.data || []; } catch (e) {}
  return rows.filter(function (a) { return Array.isArray(a.propertyIds) && a.propertyIds.indexOf(propId) !== -1; });
}

function ownerStakeOnBuilding(ownerId, b) {
  const row = (b.propertyOwners || []).find(p => p.ownerId === ownerId);
  return row ? row.share : '—';
}

let consultationSelectedSigTypes = new Set();
let consultationSigFrom = '';
let consultationSigTo = '';
let attachmentsDateFrom = '';
let attachmentsDateTo = '';
let ownerUpdatedFrom = '';
let ownerUpdatedTo = '';

function escapeCellHtml(value) {
  return String(value == null ? '' : value)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

function exportAuxRecordsCSV(pageKey) {
  const state = auxRecordStates[pageKey];
  const cfg = AUX_RECORDS_CONFIG[pageKey];
  if (!state || !cfg) return;
  const rows = state.filteredRows;
  const lines = [cfg.columns.join(',')];
  rows.forEach(r => {
    if (pageKey === 'owners') {
      lines.push([
        r.ownerId, r.ownerName, r.fatherName, r.motherName, r.phone1, r.phone2, r.email,
        (r.notesLines || []).join(' | '),
        (r.propertyIds || []).length,
        (r.signalIds || []).join('؛ '),
        r.enteredBy, r.createdAt, r.updatedAt || ''
      ].map(v => `"${String(v || '').replace(/"/g, '""')}"`).join(','));
    } else if (pageKey === 'consultations') {
      lines.push([
        r.signalId, r.signalContractNo, r.signalType, r.signalDate, (r.notesLines || (r.notes || [])).join(' | '),
        auxFormatOwnerLabels(r.claimantOwnerIds).join('؛ '),
        auxFormatOwnerLabels(r.defendantOwnerIds).join('؛ '),
        r.enteredBy, r.createdAt, r.updatedAt || ''
      ].map(v => `"${String(v || '').replace(/"/g, '""')}"`).join(','));
    } else {
      lines.push([
        r.attachmentId, r.attachmentName, r.attachmentNo || '', r.attachmentDate || '',
        String(r.summaryLine || ''),
        r.downloadName || '',
        r.enteredBy, r.createdAt, r.updatedAt || ''
      ].map(v => `"${String(v || '').replace(/"/g, '""')}"`).join(','));
    }
  });
  const blob = new Blob(['\uFEFF' + lines.join('\n')], { type: 'text/csv;charset=utf-8' });
  const a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = `${cfg.title}.csv`;
  a.click();
}

function getAuxColumnDefs(pageKey) {
  if (pageKey === 'owners') {
    return [
      { key: 'ownerId', label: 'ID المالك' },
      { key: 'ownerName', label: 'الاسم والكنية' },
      { key: 'fatherName', label: 'اسم الأب' },
      { key: 'motherName', label: 'اسم الأم' },
      { key: 'phone1', label: 'رقم هاتف 1' },
      { key: 'phone2', label: 'رقم هاتف 2' },
      { key: 'email', label: 'البريد الالكتروني' },
      { key: 'notesExpand', label: 'ملاحظات' },
      { key: 'propCountExpand', label: 'عدد العقارات التي يملكها' },
      { key: 'sigCountExpand', label: 'الإشارات' },
      { key: 'enteredBy', label: 'المدخل' },
      { key: 'createdAt', label: 'تاريخ ادخال البيانات' },
      { key: 'updatedAt', label: 'تاريخ آخر تعديل' }
    ];
  }
  if (pageKey === 'consultations') {
    return [
      { key: 'signalId', label: 'ID الاشارة' },
      { key: 'signalContractNo', label: 'رقم عقد الاشارة' },
      { key: 'signalType', label: 'نوع الاشارة' },
      { key: 'signalDate', label: 'تاريخ الاشارة' },
      { key: 'notesSig', label: 'ملاحظات الاشارة' },
      { key: 'claimants', label: 'صاحب الاشارة' },
      { key: 'defendantsDisp', label: 'المدعى عليهم' },
      { key: 'enteredBy', label: 'المدخل' },
      { key: 'createdAt', label: 'تاريخ ادخال البيانات' },
      { key: 'updatedAt', label: 'تاريخ آخر تعديل' }
    ];
  }
  return [
    { key: 'attachmentId', label: 'id الملحق' },
    { key: 'attachmentName', label: 'اسم الملحق' },
    { key: 'attachmentNo', label: 'رقم الملحق' },
    { key: 'attachmentDate', label: 'تاريخ الملحق' },
    { key: 'detailsBtn', label: 'تفاصيل' },
    { key: 'downloadBtn', label: 'زر تنزيل الملحق' },
    { key: 'enteredBy', label: 'المدخل' },
    { key: 'createdAt', label: 'تاريخ ادخال البيانات' },
    { key: 'updatedAt', label: 'تاريخ آخر تعديل' }
  ];
}

function toggleAuxExpand(pageKey, rowIndex, sectionKey) {
  const state = auxRecordStates[pageKey];
  if (!state) return;
  const k = `${rowIndex}-${sectionKey}`;
  if (state.expanded.has(k)) state.expanded.delete(k);
  else state.expanded.add(k);
  renderAuxRecordsPage(pageKey);
}

function toggleConsultSigMenu(event) {
  if (event) event.stopPropagation();
  const menu = document.getElementById('consult-sigtype-menu');
  if (!menu) return;
  const shouldOpen = !menu.classList.contains('open');
  closeAllMenus(shouldOpen ? 'consult-sigtype-menu' : '');
  menu.classList.toggle('open', shouldOpen);
}

function consultRefreshSigToggleMarks() {
  const menu = document.getElementById('consult-sigtype-menu');
  if (!menu || menu.dataset.built !== '1') return;
  menu.querySelectorAll('[data-sig]').forEach(el => {
    const raw = decodeURIComponent(el.getAttribute('data-sig') || '');
    const tg = el.querySelector('.col-toggle');
    if (tg) tg.textContent = consultationSelectedSigTypes.has(raw) ? '✓' : '';
  });
  const all = document.getElementById('consult-sig-all');
  if (all) all.textContent = consultationSelectedSigTypes.size === 0 ? '✓' : '';
}

function updateConsultSigTypeBtnLabel() {
  const btn = document.getElementById('consult-sigtype-btn');
  if (!btn) return;
  if (!consultationSelectedSigTypes.size) btn.textContent = 'نوع الإشارة';
  else if (consultationSelectedSigTypes.size === 1) btn.textContent = [...consultationSelectedSigTypes][0];
  else btn.textContent = 'أنواع (' + consultationSelectedSigTypes.size + ')';
}

function consultToggleOneSigType(el, evt) {
  if (evt) evt.stopPropagation();
  const raw = decodeURIComponent(el.getAttribute('data-sig') || '');
  if (!raw) return;
  if (consultationSelectedSigTypes.has(raw)) consultationSelectedSigTypes.delete(raw);
  else consultationSelectedSigTypes.add(raw);
  consultRefreshSigToggleMarks();
  updateConsultSigTypeBtnLabel();
  filterAuxRecords('consultations');
}

function consultClearSigTypes(evt) {
  if (evt) evt.stopPropagation();
  consultationSelectedSigTypes.clear();
  consultRefreshSigToggleMarks();
  updateConsultSigTypeBtnLabel();
  filterAuxRecords('consultations');
}

function setupConsultSigTypeMenu() {
  const menu = document.getElementById('consult-sigtype-menu');
  if (!menu || menu.dataset.built === '1') return;
  menu.dataset.built = '1';
  const types = [...new Set(AUX_RECORDS_CONFIG.consultations.data.map(r => r.signalType))];
  menu.innerHTML = '<div class="col-menu-item col-menu-selectall" onclick="consultClearSigTypes(event)"><div class="col-toggle" id="consult-sig-all">✓</div> تحديد الكل</div>' +
    types.map(t => `<div class="col-menu-item" onclick="consultToggleOneSigType(this,event)" data-sig="${encodeURIComponent(t)}"><div class="col-toggle"></div>${escapeCellHtml(t)}</div>`).join('');
  consultRefreshSigToggleMarks();
  updateConsultSigTypeBtnLabel();
}

function ownerRowPropertyCategories(r) {
  const cats = new Set();
  const subs = new Set();
  (r.propertyIds || []).forEach(pid => {
    const b = lookupBuildingByPropId(pid);
    if (!b) return;
    const idx = buildings.indexOf(b);
    cats.add(getPropertyKindOfBuilding(b, idx));
    subs.add(getPropertySubTypeOfBuilding(b, idx));
  });
  return { cats, subs };
}

function filterAuxRecords(pageKey) {
  const state = auxRecordStates[pageKey];
  if (!state) return;
  const q = (state.searchInput && state.searchInput.value ? state.searchInput.value : '').trim().toLowerCase();
  const by = (state.enteredByInput && state.enteredByInput.value ? state.enteredByInput.value : '').trim().toLowerCase();
  const from = state.fromInput && state.fromInput.value ? state.fromInput.value : '';
  const to = state.toInput && state.toInput.value ? state.toInput.value : '';
  const ownFrom = state.ownFromInput ? state.ownFromInput.value : '';
  const ownTo   = state.ownToInput   ? state.ownToInput.value   : '';

  state.filteredRows = state.rows.filter(r => {
    const hay = JSON.stringify(r).toLowerCase();
    const d = r.createdAt || '';
    // Cross-table haystacks
    var crossHay = '';
    // Related properties
    var relPropIds = r.propertyIds || (r.propId ? [r.propId] : []);
    relPropIds.forEach(function(pid) {
      var b = lookupBuildingByPropId(pid);
      if (b) crossHay += ' ' + JSON.stringify(b).toLowerCase();
    });
    // Related owners (for signals & attachments)
    var relOwnerIds = [];
    if (r.claimantOwnerIds) relOwnerIds = relOwnerIds.concat(r.claimantOwnerIds);
    if (r.defendantOwnerIds) relOwnerIds = relOwnerIds.concat(r.defendantOwnerIds);
    if (r.ownerId) relOwnerIds.push(r.ownerId);
    var allOwnRows = (AUX_RECORDS_CONFIG.owners && AUX_RECORDS_CONFIG.owners.data) || [];
    relOwnerIds.forEach(function(oid) {
      var orow = allOwnRows.find(function(o){ return o.ownerId === oid; });
      if (orow) crossHay += ' ' + JSON.stringify(orow).toLowerCase();
    });
    // Related signals (for attachments & owners)
    var relSigIds = r.signalIds || (r.signalId ? [r.signalId] : []);
    var allSigRows = (AUX_RECORDS_CONFIG.consultations && AUX_RECORDS_CONFIG.consultations.data) || [];
    relSigIds.forEach(function(sid) {
      var srow = allSigRows.find(function(s){ return s.signalId === sid; });
      if (srow) crossHay += ' ' + JSON.stringify(srow).toLowerCase();
    });
    // Related attachments (for signals & owners)
    var allAttRows = (AUX_RECORDS_CONFIG.attachments && AUX_RECORDS_CONFIG.attachments.data) || [];
    if (r.ownerId || r.signalId) {
      allAttRows.forEach(function(a) {
        var linked = (a.propertyIds||[]).some(function(pid){ return relPropIds.includes(pid); })
          || relSigIds.some(function(sid){ return (a.signalIds||[]).includes(sid); });
        if (linked) crossHay += ' ' + JSON.stringify(a).toLowerCase();
      });
    }
    let matchQ = !q || hay.includes(q) || crossHay.includes(q);
    if (!matchQ && q) {
      matchQ = Object.keys(r).some(k => String(r[k] == null ? '' : r[k]).toLowerCase().includes(q));
    }
    const matchBy = !by || String(r.enteredBy || '').toLowerCase().includes(by);
    const matchFrom = !from || d >= from;
    const matchTo = !to || d <= to;
    let matchExtras = true;
    if (pageKey === 'owners') {
      const { cats: ownerCats, subs: ownerSubs } = getOwnerCascadeState(pageKey);
      const pb = ownerRowPropertyCategories(r);
      const upd = r.updatedAt || '';
      const oufEl = document.getElementById('owners-updated-from');
      const outEl = document.getElementById('owners-updated-to');
      const ouf = oufEl ? oufEl.value : ownerUpdatedFrom;
      const out = outEl ? outEl.value : ownerUpdatedTo;
      const matchUpdFrom = !ouf || upd >= ouf;
      const matchUpdTo = !out || upd <= out;
      const matchOwnCascade =
        ownerCats.size === 0 || [...pb.cats].some(c => ownerCats.has(c));
      const matchSubCascade =
        ownerSubs.size === 0 || [...pb.subs].some(s => s && ownerSubs.has(s));

      let matchOwnCascadeProps = matchOwnCascade && matchSubCascade;
      if (ownFrom || ownTo) {
        matchOwnCascadeProps =
          matchOwnCascadeProps &&
          (r.propertyIds || []).some(pid => {
            const b = lookupBuildingByPropId(pid);
            if (!b) return false;
            const od = b.ownDate || '';
            return (!ownFrom || od >= ownFrom) && (!ownTo || od <= ownTo);
          });
      }
      matchExtras = matchUpdFrom && matchUpdTo && matchOwnCascadeProps;
    } else if (pageKey === 'consultations') {
      const sdf = document.getElementById('consult-signal-from');
      const sdt = document.getElementById('consult-signal-to');
      const sf = sdf ? sdf.value : consultationSigFrom;
      const st = sdt ? sdt.value : consultationSigTo;
      const sd = r.signalDate || '';
      matchExtras =
        (consultationSelectedSigTypes.size === 0 || consultationSelectedSigTypes.has(r.signalType)) &&
        (!sf || sd >= sf) &&
        (!st || sd <= st);
      const sdfu = document.getElementById('consult-updated-from');
      const sdtu = document.getElementById('consult-updated-to');
      const u = r.updatedAt || '';
      const uf = sdfu ? sdfu.value : '';
      const ut = sdtu ? sdtu.value : '';
      matchExtras = matchExtras && (!uf || u >= uf) && (!ut || u <= ut);
    } else if (pageKey === 'attachments') {
      const ad = document.getElementById('attach-date-from');
      const at = document.getElementById('attach-date-to');
      const da = ad ? ad.value : attachmentsDateFrom;
      const dto = at ? at.value : attachmentsDateTo;
      const attD = r.attachmentDate || '';
      matchExtras =
        (!da || attD >= da) &&
        (!dto || attD <= dto);
      const udf = document.getElementById('attach-updated-from');
      const udt = document.getElementById('attach-updated-to');
      const u = r.updatedAt || '';
      const uf = udf ? udf.value : '';
      const ut = udt ? udt.value : '';
      matchExtras = matchExtras && (!uf || u >= uf) && (!ut || u <= ut);
    }
    return matchQ && matchBy && matchFrom && matchTo && matchExtras;
  });
  renderAuxFilterChips(pageKey);
  renderAuxRecordsPage(pageKey);
}

function setAuxToolbarMode(pageKey, mode) {
  const state = auxRecordStates[pageKey];
  if (!state) return;
  // Toggle: clicking 'reports' while already in reports → close it
  if (mode === 'reports' && state.mode === 'reports') mode = 'none';
  const validMode = ['search', 'reports'].includes(mode) ? mode : 'none';
  state.mode = validMode;

  const isSearch = validMode === 'search';
  if (state.searchBtn)    state.searchBtn.style.display = isSearch ? 'none' : '';
  const inlineSearch = document.getElementById(`${pageKey}-toolbar-inline-search`);
  if (inlineSearch) inlineSearch.classList.toggle('active', isSearch);
  if (state.reportsBtn) {
    state.reportsBtn.classList.toggle('active', validMode === 'reports');
    state.reportsBtn.classList.toggle('active-caret', validMode === 'reports');
  }
  if (state.reportsPanel) state.reportsPanel.hidden = validMode !== 'reports';
  if (state.chipsWrap) state.chipsWrap.hidden = validMode !== 'reports';
  if (isSearch && state.searchInput) state.searchInput.focus();
}

function clearAuxFilter(pageKey, type) {
  const state = auxRecordStates[pageKey];
  if (!state) return;
  if (type === 'all' || type === 'search') state.searchInput.value = '';
  if (type === 'all' || type === 'enteredBy') state.enteredByInput.value = '';
  if (type === 'all' || type === 'from') {
    state.fromInput.value = '';
    if (type === 'all') {
      const toEl = state.toInput; if (toEl) toEl.value = '';
      updateDateRangeLabel(`${pageKey}-from-date`, `${pageKey}-to-date`, `${pageKey}-created-label`, `${pageKey}-created-btn`);
    } else {
      updateDateRangeLabel(`${pageKey}-from-date`, `${pageKey}-to-date`, `${pageKey}-created-label`, `${pageKey}-created-btn`);
    }
  }
  if (type === 'to') {
    state.toInput.value = '';
    updateDateRangeLabel(`${pageKey}-from-date`, `${pageKey}-to-date`, `${pageKey}-created-label`, `${pageKey}-created-btn`);
  }
  if ((type === 'all' || type === 'ownFrom') && state.ownFromInput) {
    state.ownFromInput.value = '';
    updateDateRangeLabel(`${pageKey}-own-from`, `${pageKey}-own-to`, `${pageKey}-own-label`, `${pageKey}-own-btn`);
  }
  if ((type === 'all' || type === 'ownTo') && state.ownToInput) {
    state.ownToInput.value = '';
    updateDateRangeLabel(`${pageKey}-own-from`, `${pageKey}-own-to`, `${pageKey}-own-label`, `${pageKey}-own-btn`);
  }
  if (type === 'all' || type === 'ownerCats') {
    const { cats } = getOwnerCascadeState(pageKey);
    cats.clear();
  }
  if (type === 'all' || type === 'ownerSubs') {
    const { subs } = getOwnerCascadeState(pageKey);
    subs.clear();
  }
  if (type === 'all' || type === 'ownerCascade') {
    const { cats, subs } = getOwnerCascadeState(pageKey);
    cats.clear();
    subs.clear();
  }
  if (pageKey === 'owners') {
    syncOwnerCascadeToggles(pageKey);
    updateOwnerCascadeLabel(pageKey);
    if (type === 'all' || type === 'ownerUpdRange') {
      clearDateRange('owners-updated-from', 'owners-updated-to', 'owners-updated-label', 'owners-updated-btn');
    }
  }
  if (pageKey === 'consultations' && (type === 'all' || type === 'consultSigTypes')) {
    consultationSelectedSigTypes.clear();
    consultRefreshSigToggleMarks();
    updateConsultSigTypeBtnLabel();
  }
  if (pageKey === 'consultations' && (type === 'all' || type === 'consultSigDate')) {
    clearDateRange('consult-signal-from', 'consult-signal-to', 'consult-signal-lab', 'consult-signal-db');
  }
  if (pageKey === 'consultations' && (type === 'all' || type === 'consultUpdDate')) {
    clearDateRange('consult-updated-from', 'consult-updated-to', 'consult-updated-lab', 'consult-updated-db');
  }
  if (pageKey === 'attachments' && (type === 'all' || type === 'attachDocDate')) {
    clearDateRange('attach-date-from', 'attach-date-to', 'attach-date-lab', 'attach-date-db');
  }
  if (pageKey === 'attachments' && (type === 'all' || type === 'attachUpdDate')) {
    clearDateRange('attach-updated-from', 'attach-updated-to', 'attach-updated-lab', 'attach-updated-db');
  }
  filterAuxRecords(pageKey);
}

function renderAuxFilterChips(pageKey) {
  const state = auxRecordStates[pageKey];
  if (!state || !state.chipsWrap) return;
  const items = [];
  const q = (state.searchInput && state.searchInput.value ? state.searchInput.value : '').trim();
  const by = (state.enteredByInput && state.enteredByInput.value ? state.enteredByInput.value : '').trim();
  const from = state.fromInput && state.fromInput.value ? state.fromInput.value : '';
  const to = state.toInput && state.toInput.value ? state.toInput.value : '';
  const ownFrom = state.ownFromInput ? state.ownFromInput.value : '';
  const ownTo   = state.ownToInput   ? state.ownToInput.value   : '';
  if (q) items.push({ type: 'search', label: `بحث: ${q}` });
  if (by) items.push({ type: 'enteredBy', label: `المدخل: ${by}` });
  if (from) items.push({ type: 'from', label: `تاريخ الادخال من: ${from}` });
  if (to) items.push({ type: 'to', label: `تاريخ الادخال إلى: ${to}` });
  if (ownFrom) items.push({ type: 'ownFrom', label: `تاريخ التملك من: ${ownFrom}` });
  if (ownTo)   items.push({ type: 'ownTo',   label: `تاريخ التملك إلى: ${ownTo}` });
  if (pageKey === 'owners') {
    const { cats, subs } = getOwnerCascadeState(pageKey);
    if (cats.size) items.push({ type: 'ownerCats', label: `فئة العقار: ${Array.from(cats).join('، ')}` });
    if (subs.size) items.push({ type: 'ownerSubs', label: `نوع العقار: ${Array.from(subs).join('، ')}` });
    const ouf = document.getElementById('owners-updated-from');
    const out = document.getElementById('owners-updated-to');
    if (ouf && ouf.value) items.push({ type: 'ownerUpdRange', label: `آخر تعديل من: ${ouf.value}` });
    if (out && out.value) items.push({ type: 'ownerUpdRange', label: `آخر تعديل إلى: ${out.value}` });
  }
  if (pageKey === 'consultations') {
    if (consultationSelectedSigTypes.size) {
      items.push({ type: 'consultSigTypes', label: `نوع الإشارة: ${Array.from(consultationSelectedSigTypes).join('، ')}` });
    }
    const sf = document.getElementById('consult-signal-from');
    const st = document.getElementById('consult-signal-to');
    if (sf && sf.value) items.push({ type: 'consultSigDate', label: `تاريخ إشارة من: ${sf.value}` });
    if (st && st.value) items.push({ type: 'consultSigDate', label: `تاريخ إشارة إلى: ${st.value}` });
    const uf = document.getElementById('consult-updated-from');
    const ut = document.getElementById('consult-updated-to');
    if (uf && uf.value) items.push({ type: 'consultUpdDate', label: `تعديل الإشارة من: ${uf.value}` });
    if (ut && ut.value) items.push({ type: 'consultUpdDate', label: `تعديل الإشارة إلى: ${ut.value}` });
  }
  if (pageKey === 'attachments') {
    const df = document.getElementById('attach-date-from');
    const dt = document.getElementById('attach-date-to');
    if (df && df.value) items.push({ type: 'attachDocDate', label: `تاريخ الملحق من: ${df.value}` });
    if (dt && dt.value) items.push({ type: 'attachDocDate', label: `تاريخ الملحق إلى: ${dt.value}` });
    const udf = document.getElementById('attach-updated-from');
    const udt = document.getElementById('attach-updated-to');
    if (udf && udf.value) items.push({ type: 'attachUpdDate', label: `تعديل الملحق من: ${udf.value}` });
    if (udt && udt.value) items.push({ type: 'attachUpdDate', label: `تعديل الملحق إلى: ${udt.value}` });
  }

  state.chipsWrap.innerHTML = '';
  const row = document.createElement('div');
  row.style.display = 'flex';
  row.style.alignItems = 'center';
  row.style.gap = '8px';
  row.style.flexWrap = 'wrap';
  const label = document.createElement('span');
  label.className = 'filter-label';
  label.textContent = 'التصفية الحالية:';
  row.appendChild(label);
  const list = items.length ? items : [{ type: 'all', label: 'الكل' }];
  list.forEach(item => {
    const chip = document.createElement('span');
    chip.className = 'chip active';
    chip.style.cursor = 'pointer';
    chip.setAttribute('role', 'button');
    chip.setAttribute('tabindex', '0');
    chip.onclick = () => clearAuxFilter(pageKey, item.type);
    chip.onkeydown = e => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        clearAuxFilter(pageKey, item.type);
      }
    };
    chip.appendChild(document.createTextNode(item.label + ' '));
    const x = document.createElement('span');
    x.className = 'chip-remove';
    x.textContent = '×';
    chip.appendChild(x);
    row.appendChild(chip);
  });
  state.chipsWrap.appendChild(row);
}

function renderAuxRecordsPage(pageKey) {
  const state = auxRecordStates[pageKey];
  if (!state || !state.tbody) return;
  const cfg = AUX_RECORDS_CONFIG[pageKey];
  const rowsHtml = state.filteredRows.map((r, i) => {
    const isSelected = state.selectedRows.has(r.__id);
    if (pageKey === 'owners') {
      const propsOpen = state.expanded.has(`${r.__id}-props`);
      const sigOpen = state.expanded.has(`${r.__id}-signals`);
      const notesOpen = state.expanded.has(`${r.__id}-ownNotes`);
      const propCount = (r.propertyIds || []).length;
      const sigTotal = (r.signalIds || []).length;
      const propsPanels = !(r.propertyIds || []).length ? '<div style="color:var(--text-muted);padding:4px 0">لا توجد عقارات مرتبطة.</div>'
        : (r.propertyIds || []).map((pid, pi) => {
          const b = lookupBuildingByPropId(pid);
          if (!b) return `<div style="color:var(--text-muted);padding:6px">عقار ${escapeCellHtml(pid)} — غير موجود في تقرير العقارات الحالي.</div>`;
          const idx = buildings.indexOf(b);
          const stake = ownerStakeOnBuilding(r.ownerId, b);
          const cat = getPropertyKindOfBuilding(b, idx);
          const sub = getPropertySubTypeOfBuilding(b, idx);
          return `<div style="background:rgba(212,175,55,.04);border:1px solid rgba(212,175,55,.14);border-radius:8px;padding:8px 14px;margin-bottom:6px">
            <div style="font-family:var(--font-ui);font-size:calc(12px * var(--fs-scale));color:var(--gold-mid);margin-bottom:6px;border-bottom:1px solid rgba(212,175,55,.1);padding-bottom:4px">${pi + 1} — <button type="button" class="geo-link detail-deep-link" style="font:inherit;border:0;background:none;padding:0;color:inherit;display:inline" onclick="jumpLinkedRecord('property','${pid}','pnotes')" title="فتح تقرير العقار مع الملاحظات">${escapeCellHtml(pid)}</button> • ${escapeCellHtml(b.name)}</div>
            <div class="aux-detail-grid" style="gap:4px 20px;">
              <div><div style="font-size:calc(10px * var(--fs-scale));color:var(--text-muted)">الحصة لهذا المالك</div><div style="color:var(--gold-light);font-weight:600">${escapeCellHtml(stake)}</div></div>
              <div><div style="font-size:calc(10px * var(--fs-scale));color:var(--text-muted)">محافظة</div><div>${escapeCellHtml(b.city)}</div></div>
              <div><div style="font-size:calc(10px * var(--fs-scale));color:var(--text-muted)">فئة / نوع</div><div>${escapeCellHtml(cat + (sub ? ' — ' + sub : ''))}</div></div>
              <div><div style="font-size:calc(10px * var(--fs-scale));color:var(--text-muted)">مساحة</div><div>${escapeCellHtml(formatAreaFromM2(Number(b.area) || 0))}</div></div>
            </div></div>`;
        }).join('');
      const sigPanels = !(r.signalIds || []).length
        ? '<div style="color:var(--text-muted);padding:4px 0">لا توجد إشارات لهذا السجل.</div>'
        : (r.signalIds || []).map((sid, si) => {
          const c = auxConsultRowBySigId(sid);
          if (!c) return `<div style="background:rgba(212,175,55,.04);border:1px solid rgba(212,175,55,.14);border-radius:8px;padding:8px 14px;margin-bottom:6px;color:var(--text-muted)">${si + 1} — ${escapeCellHtml(sid)} — لم يُعثر على تفاصيل.</div>`;
          const propJump = !(c.propertyIds || []).length ? '—'
            : (c.propertyIds || []).map(pidd => {
              const bb = lookupBuildingByPropId(pidd);
              const lab = bb ? `${bb.propNo} — ${bb.name}` : pidd;
              return `<button type="button" class="detail-deep-link" onclick="jumpLinkedRecord('property','${pidd}','pnotes')" title="تقرير العقار">${escapeCellHtml(lab)}</button>`;
            }).join('، ');
          const attJump = !(c.attachmentIds || []).length ? '—'
            : (c.attachmentIds || []).map(aid => {
              const ax = auxAttachmentRowById(aid);
              const lab = ax ? `${ax.attachmentName} (${aid})` : aid;
              return `<button type="button" class="detail-deep-link" onclick="jumpLinkedRecord('attachment','${aid}')" title="تقرير الملحق">${escapeCellHtml(lab)}</button>`;
            }).join('، ');
          const typeBadge = c.signalType
            ? `<span style="background:rgba(212,175,55,.1);border:1px solid rgba(212,175,55,.2);border-radius:20px;padding:2px 10px;font-size:calc(10.5px * var(--fs-scale));color:var(--gold-light)">${escapeCellHtml(c.signalType)}</span>`
            : '';
          return `<div style="background:rgba(212,175,55,.04);border:1px solid rgba(212,175,55,.14);border-radius:8px;padding:8px 14px;margin-bottom:6px">
            <div style="font-family:var(--font-ui);font-size:calc(12px * var(--fs-scale));color:var(--gold-mid);margin-bottom:6px;border-bottom:1px solid rgba(212,175,55,.1);padding-bottom:4px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:6px">
              <span>${si + 1} — <button type="button" class="detail-deep-link" style="color:inherit;font:inherit" onclick="jumpLinkedRecord('consultation','${c.signalId}')" title="تقرير الإشارات">${escapeCellHtml(c.signalId)}</button> • ${escapeCellHtml(c.signalContractNo)}</span>
              ${typeBadge}
            </div>
            <div class="aux-detail-grid" style="gap:4px 20px;">
              <div><div style="font-size:calc(10px * var(--fs-scale));color:var(--text-muted)">تاريخ الإشارة</div><div style="font-variant-numeric:tabular-nums;direction:ltr;text-align:right">${escapeCellHtml(c.signalDate)}</div></div>
              <div><div style="font-size:calc(10px * var(--fs-scale));color:var(--text-muted)">صاحب الإشارة</div><div style="color:var(--gold-light);font-weight:600">${escapeCellHtml(auxFormatOwnerLabels(c.claimantOwnerIds).join('، '))}</div></div>
              <div><div style="font-size:calc(10px * var(--fs-scale));color:var(--text-muted)">المدعى عليهم</div><div>${escapeCellHtml(auxFormatOwnerLabels((c.defendantOwnerIds || []).filter(Boolean)).join('، ') || '—')}</div></div>
              <div><div style="font-size:calc(10px * var(--fs-scale));color:var(--text-muted)">العقارات المرتبطة</div><div>${propJump}</div></div>
              <div style="grid-column:1/-1"><div style="font-size:calc(10px * var(--fs-scale));color:var(--text-muted);margin-bottom:2px">الملفات المقترنة</div><div>${attJump}${(c.fileNames || []).length ? '<span style="color:var(--text-muted);font-size:calc(10px * var(--fs-scale))"> — ' + escapeCellHtml((c.fileNames || []).join('؛ ')) + '</span>' : ''}</div></div>
            </div></div>`;
        }).join('');
      return `<tr class="aux-main-row ${isSelected ? 'selected-row' : ''}" data-aux-rid="${escapeCellHtml(r.__id)}">
        <td class="select-col" style="text-align:center">${state.multiSelectEnabled ? `<input type="checkbox" ${isSelected ? 'checked' : ''} onchange="toggleAuxRowSelection('owners','${r.__id}',this.checked,this)">` : ''}</td>
        <td class="col-ownerId"><span class="id-badge">${escapeCellHtml(r.ownerId)}</span></td>
        <td class="col-ownerName">${escapeCellHtml(r.ownerName)}</td>
        <td class="col-fatherName">${escapeCellHtml(r.fatherName)}</td>
        <td class="col-motherName">${escapeCellHtml(r.motherName)}</td>
        <td class="col-phone1">${escapeCellHtml(r.phone1)}</td>
        <td class="col-phone2">${escapeCellHtml(r.phone2)}</td>
        <td class="col-email">${escapeCellHtml(r.email)}</td>
        <td class="col-notesExpand" style="text-align:center"><button type="button" class="details-toggle" onclick="toggleAuxExpand('owners','${r.__id}','ownNotes')"><span>ملاحظات</span><span>${notesOpen ? '▴' : '▾'}</span></button></td>
        <td class="col-propCountExpand" style="text-align:center">${propCount ? `<button type="button" class="details-toggle" onclick="toggleAuxExpand('owners','${r.__id}','props')"><span>${propCount}</span><span>${propsOpen ? '▴' : '▾'}</span></button>` : '0'}</td>
        <td class="col-sigCountExpand" style="text-align:center">${sigTotal ? `<button type="button" class="details-toggle" onclick="toggleAuxExpand('owners','${r.__id}','signals')"><span>${sigTotal}</span><span>${sigOpen ? '▴' : '▾'}</span></button>` : '0'}</td>
        <td class="col-enteredBy">${escapeCellHtml(r.enteredBy)}</td>
        <td class="col-createdAt">${escapeCellHtml(r.createdAt)}</td>
        <td class="col-updatedAt">${escapeCellHtml(r.updatedAt || '')}</td>
      </tr>
      <tr class="detail-row ${notesOpen ? 'open' : ''}"><td class="detail-cell" colspan="${state.columns.length + 1}">
        ${(r.notesLines || []).length ? `<ul style="margin:0;padding-inline-start:1.25em;line-height:1.6">${(r.notesLines || []).map(n => `<li>${escapeCellHtml(n)}</li>`).join('')}</ul>` : '<span style="color:var(--text-muted)">لا توجد ملاحظات</span>'}</td></tr>
      <tr class="detail-row ${propsOpen ? 'open' : ''}"><td class="detail-cell" colspan="${state.columns.length + 1}"><div style="padding:2px 0 4px">${propsPanels}</div></td></tr>
      <tr class="detail-row ${sigOpen ? 'open' : ''}"><td class="detail-cell" colspan="${state.columns.length + 1}"><div style="padding:2px 0 4px">${sigPanels}</div></td></tr>`;
    }
    if (pageKey === 'consultations') {
      const notesOpen = state.expanded.has(`${r.__id}-notes`);
      const omConsult = getAuxOwnerRowMap();
      const ownerLinks = (ids) => (ids || []).filter(Boolean).map(oid => {
        const rowm = omConsult[oid];
        const lab = rowm ? rowm.ownerName : oid;
        return `<button type="button" class="geo-link detail-deep-link" style="font:inherit;border:0;background:none;padding:0;display:inline" onclick="jumpLinkedRecord('owner','${oid}')" title="تقرير المالك">${escapeCellHtml(lab)}</button>`;
      }).join('، ');
      const propLinksBlock = !(r.propertyIds || []).length ? '—'
        : (r.propertyIds || []).map(pid => {
          const b = lookupBuildingByPropId(pid);
          const lab = b ? `${b.propNo} (${b.name})` : pid;
          return `<button type="button" class="geo-link detail-deep-link" style="font:inherit;border:0;background:none;padding:0;display:inline" onclick="jumpLinkedRecord('property','${pid}','pnotes')" title="تقرير العقار">${escapeCellHtml(lab)}</button>`;
        }).join('؛ ');
      const attLinksBlock = !(r.attachmentIds || []).length ? '—'
        : (r.attachmentIds || []).map(aid => {
          const att = auxAttachmentRowById(aid);
          const lab = att ? `${att.attachmentName} [${aid}]` : aid;
          return `<button type="button" class="geo-link detail-deep-link" style="font:inherit;border:0;background:none;padding:0;display:inline" onclick="jumpLinkedRecord('attachment','${aid}')" title="تقرير الملحق">${escapeCellHtml(lab)}</button>`;
        }).join('؛ ');
      const consultNoteExtras = `
        <div style="margin-top:10px;display:grid;gap:10px;font-size:calc(11px * var(--fs-scale))">
          <div><strong style="color:var(--gold-mid)">الملاك / الأطراف</strong><br>صاحب الإشارة: ${ownerLinks(r.claimantOwnerIds) || '—'}<br>المدعى عليهم (من تقرير المالك): ${ownerLinks((r.defendantOwnerIds || []).filter(Boolean)) || '—'}</div>
          <div><strong style="color:var(--gold-mid)">العقارات المرتبطة</strong><br>${propLinksBlock}</div>
          <div><strong style="color:var(--gold-mid)">الملحقات والملفات</strong><br>${attLinksBlock}${(r.fileNames || []).length ? '<br><span style="color:var(--text-muted)">أسماء الملفات: ' + escapeCellHtml((r.fileNames || []).join('؛ ')) + '</span>' : ''}</div>
        </div>`;
      return `<tr class="aux-main-row ${isSelected ? 'selected-row' : ''}" data-aux-rid="${escapeCellHtml(r.__id)}">
        <td class="select-col" style="text-align:center">${state.multiSelectEnabled ? `<input type="checkbox" ${isSelected ? 'checked' : ''} onchange="toggleAuxRowSelection('consultations','${r.__id}',this.checked,this)">` : ''}</td>
        <td class="col-signalId"><span class="id-badge">${escapeCellHtml(r.signalId)}</span></td>
        <td class="col-signalContractNo">${escapeCellHtml(r.signalContractNo)}</td>
        <td class="col-signalType">${escapeCellHtml(r.signalType)}</td>
        <td class="col-signalDate">${escapeCellHtml(r.signalDate)}</td>
        <td class="col-notesSig" style="text-align:center"><button type="button" class="details-toggle" onclick="toggleAuxExpand('consultations','${r.__id}','notes')"><span>تفاصيل</span><span>${notesOpen ? '▴' : '▾'}</span></button></td>
        <td class="col-claimants">${ownerLinks(r.claimantOwnerIds) || '—'}</td>
        <td class="col-defendantsDisp">${ownerLinks((r.defendantOwnerIds || []).filter(Boolean)) || '—'}</td>
        <td class="col-enteredBy">${escapeCellHtml(r.enteredBy)}</td>
        <td class="col-createdAt">${escapeCellHtml(r.createdAt)}</td>
        <td class="col-updatedAt">${escapeCellHtml(r.updatedAt || '')}</td>
      </tr>
      <tr class="detail-row ${notesOpen ? 'open' : ''}"><td class="detail-cell" colspan="${state.columns.length + 1}">
        <div>${(r.notesLines || (r.notes || [])).map(n => `<p style="margin:0 0 6px;line-height:1.5">${escapeCellHtml(n)}</p>`).join('') || '<span style="color:var(--text-muted)">لا توجد ملاحظات</span>'}</div>
        ${consultNoteExtras}</td></tr>`;
    }
    const detOpen = state.expanded.has(`${r.__id}-attdet`);
    const propLines = !(r.propertyIds || []).length
      ? '<span style="color:var(--text-muted)">—</span>'
      : (r.propertyIds || []).map(pid => {
        const b = lookupBuildingByPropId(pid);
        const lab = b ? `${b.propId} — ${b.name} — ${b.city}` : pid;
        return `<div><button type="button" class="geo-link detail-deep-link" style="font:inherit;border:0;background:none;padding:0;text-align:start;display:block;width:100%" onclick="jumpLinkedRecord('property','${pid}','pnotes')" title="تقرير العقار">${escapeCellHtml(lab)}</button></div>`;
      }).join('');
    const sigLines = !(r.signalIds || []).length
      ? '<span style="color:var(--text-muted)">—</span>'
      : (r.signalIds || []).map(sid => {
        const s = auxConsultRowBySigId(sid);
        const lab = s ? `${s.signalId} (${s.signalContractNo}) نوع ${s.signalType}` : sid;
        return `<div><button type="button" class="geo-link detail-deep-link" style="font:inherit;border:0;background:none;padding:0;text-align:start;display:block;width:100%" onclick="jumpLinkedRecord('consultation','${sid}')" title="تقرير الإشارات">${escapeCellHtml(lab)}</button></div>`;
      }).join('');
    return `<tr class="aux-main-row ${isSelected ? 'selected-row' : ''}" data-aux-rid="${escapeCellHtml(r.__id)}">
      <td class="select-col" style="text-align:center">${state.multiSelectEnabled ? `<input type="checkbox" ${isSelected ? 'checked' : ''} onchange="toggleAuxRowSelection('attachments','${r.__id}',this.checked,this)">` : ''}</td>
      <td class="col-attachmentId"><span class="id-badge">${escapeCellHtml(r.attachmentId)}</span></td>
      <td class="col-attachmentName">${escapeCellHtml(r.attachmentName)}</td>
      <td class="col-attachmentNo">${escapeCellHtml(r.attachmentNo || '—')}</td>
      <td class="col-attachmentDate">${escapeCellHtml(r.attachmentDate || '')}</td>
      <td class="col-detailsBtn" style="text-align:center"><button type="button" class="details-toggle" onclick="toggleAuxExpand('attachments','${r.__id}','attdet')"><span>تفاصيل</span><span>${detOpen ? '▴' : '▾'}</span></button></td>
      <td class="col-downloadBtn" style="text-align:center"><button class="toolbar-btn toolbar-btn-outline" type="button" onclick="alert('جاري تنزيل: ${escapeCellHtml(r.downloadName)}')">تنزيل</button></td>
      <td class="col-enteredBy">${escapeCellHtml(r.enteredBy)}</td>
      <td class="col-createdAt">${escapeCellHtml(r.createdAt)}</td>
      <td class="col-updatedAt">${escapeCellHtml(r.updatedAt || '')}</td>
    </tr>
    <tr class="detail-row ${detOpen ? 'open' : ''}"><td class="detail-cell" colspan="${state.columns.length + 1}">
      <div style="line-height:1.65;font-size:calc(11px * var(--fs-scale))">
        ${r.summaryLine ? `<p style="margin:0 0 8px">${escapeCellHtml(r.summaryLine)}</p>` : ''}
        <strong style="color:var(--gold-mid)">عودة إلى العقارات</strong>${propLines}
        <div style="height:14px"></div><strong style="color:var(--gold-mid)">مرتبط بالإشارات</strong>${sigLines}
      </div></td></tr>`;
  }).join('');
  state.tbody.innerHTML = rowsHtml || `<tr><td colspan="${cfg.columns.length + 1}" style="text-align:center;color:var(--text-muted);padding:18px">لا توجد نتائج مطابقة.</td></tr>`;
  state.table.classList.toggle('hide-select', !state.multiSelectEnabled);
  applyAuxColumnOrder(pageKey);
  applyAuxColumnVisibility(pageKey);
  setupAuxColumnReorderHandlers(pageKey);
  ensureColumnResizers(`${pageKey}-table`, `${pageKey}-colgroup`);
  bindColumnResizeHandlers(`${pageKey}-table`, `${pageKey}-colgroup`);
  updateAuxSelectedCount(pageKey);
  state.rowCountEl.textContent = state.filteredRows.length.toLocaleString('ar-SA');
  syncAllPagesTableScrollState();
  requestFloatingTableHeadSync();
  updateTableScrollStartButtons();
  if (typeof updateAllTblNavPills === 'function') updateAllTblNavPills();
  if (typeof window._wireTblNavPills === 'function') window._wireTblNavPills();
  // Inject pin buttons (idempotent) and re-apply pinning
  requestAnimationFrame(() => {
    injectPinButtons(state.table?.parentElement);
    applyColumnPinning(`${pageKey}-table`);
  });
}

function updateAuxSelectedCount(pageKey) {
  const state = auxRecordStates[pageKey];
  if (!state || !state.selectedCountEl) return;
  state.selectedCountEl.textContent = state.selectedRows.size.toLocaleString('ar-SA');
}

function toggleAuxRowSelection(pageKey, rowId, checked, inputEl) {
  const state = auxRecordStates[pageKey];
  if (!state) return;
  if (checked) state.selectedRows.add(rowId);
  else state.selectedRows.delete(rowId);
  if (inputEl && inputEl.closest) {
    const row = inputEl.closest('tr');
    if (row) row.classList.toggle('selected-row', checked);
  }
  if (pageKey === 'owners') renderOwnersSelectionCards();
  updateAuxSelectedCount(pageKey);
}

function toggleAuxSelectAll(pageKey) {
  const state = auxRecordStates[pageKey];
  if (!state) return;
  const visible = state.filteredRows;
  const allSelected = visible.length > 0 && visible.every(r => state.selectedRows.has(r.__id));
  if (allSelected) visible.forEach(r => state.selectedRows.delete(r.__id));
  else visible.forEach(r => state.selectedRows.add(r.__id));
  if (pageKey === 'owners') renderOwnersSelectionCards();
  renderAuxRecordsPage(pageKey);
}

function parseShareFractionFromLabel(shareStr) {
  const n = parseFloat(String(shareStr || '').replace(/[^\d.]/g, ''));
  if (!isFinite(n) || n <= 0) return 0;
  return Math.min(100, n) / 100;
}

function ownerPortfolioUsdTotals(ownerRow) {
  let approx = 0;
  let actual = 0;
  (ownerRow.propertyIds || []).forEach(pid => {
    const b = lookupBuildingByPropId(pid);
    if (!b) return;
    const frac = parseShareFractionFromLabel(ownerStakeOnBuilding(ownerRow.ownerId, b));
    if (!(frac > 0)) return;
    const act = Number(b.actualPriceUsd != null ? b.actualPriceUsd : b.value) || 0;
    const apr = Number(b.approxPriceUsd != null ? b.approxPriceUsd : act * 0.94) || 0;
    actual += act * frac;
    approx += apr * frac;
  });
  return { approx, actual };
}

function renderOwnersSelectionCards() {
  const state = auxRecordStates['owners'];
  const cfg = AUX_RECORDS_CONFIG['owners'];
  const allRows = cfg ? cfg.data : [];
  const totalApprox = allRows.reduce((s, r) => s + ownerPortfolioUsdTotals(r).approx, 0);
  const totalActual = allRows.reduce((s, r) => s + ownerPortfolioUsdTotals(r).actual, 0);

  const selectedIds = state ? state.selectedRows : new Set();
  const selectedRows = allRows.filter((r, i) => selectedIds.has(`owners-${i + 1}`));
  const hasSelection = selectedRows.length > 0;
  const source = hasSelection ? selectedRows : allRows;
  const modeLabel = hasSelection ? `${selectedRows.length} مالك محدد` : 'جميع الملاك';
  const modeText = hasSelection ? 'الملاك المحددون' : 'جميع الملاك';

  const sumApprox = source.reduce((s, r) => s + ownerPortfolioUsdTotals(r).approx, 0);
  const sumActual = source.reduce((s, r) => s + ownerPortfolioUsdTotals(r).actual, 0);
  const pctApprox = totalApprox ? Math.min(100, Math.round((sumApprox / totalApprox) * 100)) : 0;
  const pctActual = totalActual ? Math.min(100, Math.round((sumActual / totalActual) * 100)) : 0;

  const fmt = v => '$' + Number(v).toLocaleString('en-US');

  const approxVal = document.getElementById('owners-approx-value');
  const approxCount = document.getElementById('owners-approx-count');
  const approxBar = document.getElementById('owners-approx-bar');
  const approxMode = document.getElementById('owners-approx-mode');
  const actualVal = document.getElementById('owners-actual-value');
  const actualCount = document.getElementById('owners-actual-count');
  const actualBar = document.getElementById('owners-actual-bar');
  const actualMode = document.getElementById('owners-actual-mode');

  if (approxVal) approxVal.textContent = sumApprox ? fmt(sumApprox) : '—';
  if (approxCount) approxCount.textContent = modeLabel;
  if (approxBar) approxBar.style.width = pctApprox + '%';
  if (approxMode) approxMode.textContent = modeText;
  if (actualVal) actualVal.textContent = sumActual ? fmt(sumActual) : '—';
  if (actualCount) actualCount.textContent = modeLabel;
  if (actualBar) actualBar.style.width = pctActual + '%';
  if (actualMode) actualMode.textContent = modeText;
}

const STATS_GEN_MAX_POINTS = 6;
const STATS_GEN_PALETTE = ['#D4AF37','#60a5fa','#34d399','#f59e0b','#f87171','#a78bfa','#22c55e','#C49A2A'];

const STATS_GENERATOR_SOURCE_CONFIG = {
  properties: {
    label: 'تقرير العقارات',
    labelFields: [
      { key: 'propNo', label: 'رقم العقار' },
      { key: 'city', label: 'المدينة' },
      { key: 'status', label: 'الحالة' },
      { key: 'typeText', label: 'نوع العقار' }
    ],
    valueFields: [
      { key: '__count__', label: 'عدد السجلات' },
      { key: 'area', label: 'المساحة' },
      { key: 'value', label: 'القيمة' },
      { key: 'rent', label: 'الإيجار' },
      { key: 'share', label: 'نسبة التملك' },
      { key: 'units', label: 'عدد الوحدات' }
    ]
  },
  owners: {
    label: 'تقرير المالك',
    labelFields: [
      { key: 'ownerName', label: 'الاسم' },
      { key: 'propertyCategory', label: 'فئة العقار' },
      { key: 'propertySubType', label: 'نوع العقار' },
      { key: 'enteredBy', label: 'المدخل' }
    ],
    valueFields: [
      { key: '__count__', label: 'عدد السجلات' },
      { key: 'portfolioApprox', label: 'محفظة تقريبية ($)' },
      { key: 'portfolioActual', label: 'محفظة فعلية ($)' },
      { key: 'ownerPropertyCount', label: 'عدد عقارات المالك' }
    ]
  },
  consultations: {
    label: 'تقرير الإشارات',
    labelFields: [
      { key: 'signalType', label: 'نوع الإشارة' },
      { key: 'claimantsLabel', label: 'صاحب الإشارة' },
      { key: 'enteredBy', label: 'المدخل' }
    ],
    valueFields: [
      { key: '__count__', label: 'عدد السجلات' }
    ]
  },
  attachments: {
    label: 'تقرير الملحقات',
    labelFields: [
      { key: 'attachmentName', label: 'اسم الملحق' },
      { key: 'enteredBy', label: 'المدخل' }
    ],
    valueFields: [
      { key: '__count__', label: 'عدد السجلات' }
    ]
  }
};

function statsGenToWesternDigits(s) {
  return String(s)
    .replace(/[٠-٩]/g, d => String('٠١٢٣٤٥٦٧٨٩'.indexOf(d)))
    .replace(/[۰-۹]/g, d => String('۰۱۲۳۴۵۶۷۸۹'.indexOf(d)));
}

function statsGenToNumber(value) {
  if (typeof value === 'number') return isFinite(value) ? value : 0;
  const normalized = statsGenToWesternDigits(value == null ? '' : value)
    .replace(/,/g, '')
    .replace(/[^\d.-]/g, '');
  const n = Number(normalized);
  return isFinite(n) ? n : 0;
}

function getStatsGeneratorRows(source) {
  if (source === 'properties') {
    const selectedRows = buildings.filter(b => selectedProps.has(b.propNo));
    const rows = selectedRows.length ? selectedRows : filteredData.slice();
    return rows.map((b, idx) => ({
      propNo: b.propNo || `عقار ${idx + 1}`,
      city: b.city || 'غير محدد',
      status: b.status || 'غير محدد',
      typeText: getPropertyKindOfBuilding(b, buildings.indexOf(b)),
      area: Number(b.area) || 0,
      value: Number(b.value) || 0,
      rent: Number(b.rent) || 0,
      share: Number(b.share) || 0,
      units: Number(b.units) || 0
    }));
  }
  const state = auxRecordStates[source];
  if (!state) return [];
  const selected = state.rows.filter(r => state.selectedRows.has(r.__id));
  const sourceRows = selected.length ? selected : (Array.isArray(state.filteredRows) ? state.filteredRows : state.rows);
  if (source === 'owners') {
    return sourceRows.map(r => {
      const pb = ownerRowPropertyCategories(r);
      const cats = [...pb.cats];
      const subs = [...pb.subs].filter(Boolean);
      const port = ownerPortfolioUsdTotals(r);
      return {
        ownerName: r.ownerName || 'غير محدد',
        propertyCategory: cats[0] || 'غير محدد',
        propertySubType: subs[0] || 'غير محدد',
        enteredBy: r.enteredBy || 'غير محدد',
        portfolioApprox: Number(port.approx) || 0,
        portfolioActual: Number(port.actual) || 0,
        ownerPropertyCount: Number((r.propertyIds || []).length) || 0
      };
    });
  }
  if (source === 'consultations') {
    return sourceRows.map(r => ({
      signalType: r.signalType || 'غير محدد',
      claimantsLabel: auxFormatOwnerLabels(r.claimantOwnerIds || []).join('، ') || 'غير محدد',
      enteredBy: r.enteredBy || 'غير محدد'
    }));
  }
  return sourceRows.map(r => ({
    attachmentName: r.attachmentName || 'غير محدد',
    enteredBy: r.enteredBy || 'غير محدد'
  }));
}

function statsGeneratorPopulateFields() {
  const sourceEl = document.getElementById('stats-gen-source');
  const labelEl = document.getElementById('stats-gen-label-field');
  const valueEl = document.getElementById('stats-gen-value-field');
  if (!sourceEl || !labelEl || !valueEl) return;
  const source = sourceEl.value;
  const cfg = STATS_GENERATOR_SOURCE_CONFIG[source];
  if (!cfg) return;
  labelEl.innerHTML = cfg.labelFields.map(f => `<option value="${f.key}">${f.label}</option>`).join('');
  valueEl.innerHTML = cfg.valueFields.map(f => `<option value="${f.key}">${f.label}</option>`).join('');
}

function statsGenSetStatus(message, kind) {
  const status = document.getElementById('stats-gen-status');
  if (!status) return;
  status.classList.remove('error', 'ok');
  if (kind) status.classList.add(kind);
  status.textContent = message;
}

function statsGenBuildGroupedData(rows, labelField, valueField) {
  const buckets = new Map();
  rows.forEach(row => {
    const label = String(row[labelField] || 'غير محدد');
    const inc = valueField === '__count__' ? 1 : statsGenToNumber(row[valueField]);
    buckets.set(label, (buckets.get(label) || 0) + inc);
  });
  return Array.from(buckets.entries())
    .map(([label, value]) => ({ label, value: Number(value) || 0 }))
    .sort((a, b) => b.value - a.value)
    .slice(0, STATS_GEN_MAX_POINTS);
}

function statsGenSvgBar(rows) {
  const w = 520, h = 240, pad = 34, innerW = w - pad * 2, innerH = h - pad * 2;
  const max = Math.max(1, ...rows.map(r => r.value));
  const bw = innerW / Math.max(1, rows.length);
  const bars = rows.map((r, i) => {
    const v = r.value / max;
    const x = pad + i * bw + 8;
    const y = pad + innerH - (v * innerH);
    const hh = Math.max(4, v * innerH);
    return `<g>
      <rect x="${x}" y="${y}" width="${Math.max(8, bw - 16)}" height="${hh}" rx="4" fill="${STATS_GEN_PALETTE[i % STATS_GEN_PALETTE.length]}"></rect>
      <text x="${x + Math.max(8, bw - 16)/2}" y="${pad + innerH + 16}" fill="var(--text-secondary)" text-anchor="middle" font-size="10">${r.label.slice(0, 10)}</text>
      <text x="${x + Math.max(8, bw - 16)/2}" y="${Math.max(14, y - 4)}" fill="var(--gold-light)" text-anchor="middle" font-size="9">${Math.round(r.value).toLocaleString('ar-SA')}</text>
    </g>`;
  }).join('');
  return `<svg class="stats-svg" viewBox="0 0 ${w} ${h}" xmlns="http://www.w3.org/2000/svg">
    <line x1="${pad}" y1="${pad + innerH}" x2="${pad + innerW}" y2="${pad + innerH}" stroke="rgba(148,163,184,.5)" />
    <line x1="${pad}" y1="${pad}" x2="${pad}" y2="${pad + innerH}" stroke="rgba(148,163,184,.5)" />
    ${bars}
  </svg>`;
}

function statsGenSvgLine(rows) {
  const w = 520, h = 240, pad = 34, innerW = w - pad * 2, innerH = h - pad * 2;
  const max = Math.max(1, ...rows.map(r => r.value));
  const points = rows.map((r, i) => {
    const x = pad + (i * innerW) / Math.max(1, rows.length - 1);
    const y = pad + innerH - ((r.value / max) * innerH);
    return { x, y, label: r.label, value: r.value };
  });
  return `<svg class="stats-svg" viewBox="0 0 ${w} ${h}" xmlns="http://www.w3.org/2000/svg">
    <line x1="${pad}" y1="${pad + innerH}" x2="${pad + innerW}" y2="${pad + innerH}" stroke="rgba(148,163,184,.5)" />
    <line x1="${pad}" y1="${pad}" x2="${pad}" y2="${pad + innerH}" stroke="rgba(148,163,184,.5)" />
    <polyline fill="none" stroke="var(--gold-bright)" stroke-width="2.5" points="${points.map(p => `${p.x},${p.y}`).join(' ')}"></polyline>
    ${points.map((p, i) => `<g>
      <circle cx="${p.x}" cy="${p.y}" r="3.5" fill="${STATS_GEN_PALETTE[i % STATS_GEN_PALETTE.length]}"></circle>
      <text x="${p.x}" y="${pad + innerH + 16}" fill="var(--text-secondary)" text-anchor="middle" font-size="10">${p.label.slice(0, 10)}</text>
    </g>`).join('')}
  </svg>`;
}

function statsGenPolarToCartesian(cx, cy, r, angleDeg) {
  const rad = (angleDeg * Math.PI) / 180;
  return { x: cx + r * Math.cos(rad), y: cy + r * Math.sin(rad) };
}

function statsGenDescribeArc(cx, cy, r, startAngle, endAngle) {
  const s = statsGenPolarToCartesian(cx, cy, r, endAngle);
  const e = statsGenPolarToCartesian(cx, cy, r, startAngle);
  const large = endAngle - startAngle <= 180 ? '0' : '1';
  return `M ${cx} ${cy} L ${e.x} ${e.y} A ${r} ${r} 0 ${large} 1 ${s.x} ${s.y} Z`;
}

function statsGenPie(rows) {
  const total = rows.reduce((s, r) => s + r.value, 0) || 1;
  let start = -90;
  const sectors = rows.map((r, i) => {
    const ang = (r.value / total) * 360;
    const end = start + ang;
    const path = statsGenDescribeArc(95, 95, 80, start, end);
    const color = STATS_GEN_PALETTE[i % STATS_GEN_PALETTE.length];
    start = end;
    return { path, color, label: r.label, value: r.value };
  });
  return `<div class="stats-pie-wrap">
    <svg class="stats-svg" viewBox="0 0 200 200" style="max-width:220px" xmlns="http://www.w3.org/2000/svg">
      ${sectors.map(s => `<path d="${s.path}" fill="${s.color}"></path>`).join('')}
      <circle cx="95" cy="95" r="36" fill="rgba(10,10,10,.7)"></circle>
      <text x="95" y="92" text-anchor="middle" fill="var(--gold-light)" font-size="12">${total.toLocaleString('ar-SA')}</text>
      <text x="95" y="108" text-anchor="middle" fill="var(--text-secondary)" font-size="10">إجمالي</text>
    </svg>
    <div class="stats-pie-legend">
      ${sectors.map(s => `<div class="stats-pie-item"><span class="stats-pie-dot" style="background:${s.color}"></span>${s.label} (${Math.round((s.value / total) * 100)}٪)</div>`).join('')}
    </div>
  </div>`;
}

function createStatsGeneratedChart() {
  const source = (document.getElementById('stats-gen-source') || {}).value || 'properties';
  const type = (document.getElementById('stats-gen-type') || {}).value || 'bar';
  const labelField = (document.getElementById('stats-gen-label-field') || {}).value;
  const valueField = (document.getElementById('stats-gen-value-field') || {}).value;
  const rows = getStatsGeneratorRows(source);
  if (!rows.length) {
    statsGenSetStatus('لا توجد بيانات متاحة حالياً لهذا المصدر.', 'error');
    return;
  }
  const grouped = statsGenBuildGroupedData(rows, labelField, valueField).filter(r => r.value > 0);
  if (!grouped.length) {
    statsGenSetStatus('لا يمكن إنشاء مخطط من هذه الحقول حالياً. جرّب حقلاً رقمياً أو "عدد السجلات".', 'error');
    return;
  }
  const chartRoot = document.getElementById('stats-generator-charts');
  if (!chartRoot) return;
  const card = document.createElement('div');
  card.className = 'stats-generated-card chart-card';
  const sourceName = (STATS_GENERATOR_SOURCE_CONFIG[source] || {}).label || source;
  const chartBodyId = `stats-generated-body-${Date.now()}-${Math.floor(Math.random() * 10000)}`;
  const chartHtml = `<div id="${chartBodyId}" class="stats-generated-chart-body"></div>`;
  card.innerHTML = `
    <div class="chart-header stats-generated-header">
      <div>
        <div class="chart-title stats-generated-title">${sourceName} • ${type === 'bar' ? 'أعمدة' : type === 'line' ? 'خطي' : 'دائري'}</div>
        <div class="stats-generated-meta">${grouped.length.toLocaleString('ar-SA')} عنصر ظاهر</div>
      </div>
      <div style="display:flex; align-items:center; gap:8px">
        <span class="chart-badge">${valueField === '__count__' ? 'عدد السجلات' : 'مجموع القيم'}</span>
        <button type="button" class="toolbar-btn toolbar-btn-outline" onclick="this.closest('.stats-generated-card').remove()">حذف</button>
      </div>
    </div>
    ${chartHtml}
  `;
  chartRoot.appendChild(card);
  const body = document.getElementById(chartBodyId);
  if (body) {
    if (type === 'bar') {
      body.className = 'bar-chart';
      renderSimpleBars(body, grouped, [
        'linear-gradient(180deg, var(--gold-bright), var(--gold-deep))',
        'linear-gradient(180deg, #60a5fa, #2563eb)',
        'linear-gradient(180deg, #34d399, #059669)',
        'linear-gradient(180deg, #f59e0b, #b45309)'
      ]);
    } else if (type === 'line') {
      const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
      svg.classList.add('legal-svg-chart');
      svg.setAttribute('viewBox', '0 0 320 200');
      svg.setAttribute('preserveAspectRatio', 'xMidYMid meet');
      body.appendChild(svg);
      renderLegalTrend(svg, grouped);
    } else {
      const wrap = document.createElement('div');
      wrap.className = 'donut-wrap stats-pie-wrap';
      const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
      svg.classList.add('donut-svg');
      svg.setAttribute('viewBox', '0 0 320 200');
      svg.setAttribute('preserveAspectRatio', 'xMidYMid meet');
      svg.setAttribute('width', '164');
      svg.setAttribute('height', '168');
      const legend = document.createElement('div');
      legend.className = 'legal-legend-row stats-pie-legend';
      wrap.appendChild(svg);
      wrap.appendChild(legend);
      body.appendChild(wrap);
      renderLegalDonut(svg, legend, grouped);
    }
  }
  const selectedCount = (function () {
    if (source === 'properties') return buildings.filter(b => selectedProps.has(b.propNo)).length;
    const state = auxRecordStates[source];
    return state && state.selectedRows ? state.selectedRows.size : 0;
  })();
  const modeLabel = selectedCount > 0 ? 'من البيانات المحددة' : 'من نتائج التصفية';
  statsGenSetStatus(`تم إنشاء المخطط بنجاح (${modeLabel}) بعدد ${rows.length.toLocaleString('ar-SA')} صف. يمكنك إنشاء المزيد.`, 'ok');
}

function resetStatsGenerator() {
  const root = document.getElementById('stats-generator-charts');
  if (root) root.innerHTML = '';
  const sourceEl = document.getElementById('stats-gen-source');
  const typeEl = document.getElementById('stats-gen-type');
  if (sourceEl) sourceEl.value = 'properties';
  if (typeEl) typeEl.value = 'bar';
  statsGeneratorPopulateFields();
  statsGenSetStatus('تمت إعادة التعيين بالكامل. يمكنك البدء من جديد.', '');
}

function toggleAuxMultiSelect(pageKey) {
  const state = auxRecordStates[pageKey];
  if (!state) return;
  state.multiSelectEnabled = !state.multiSelectEnabled;
  if (!state.multiSelectEnabled) {
    state.selectedRows.clear();
    if (state.selectAllEl) state.selectAllEl.checked = false;
  }
  if (state.multiSelectBtn) {
    state.multiSelectBtn.textContent = state.multiSelectEnabled ? 'إلغاء الاختيار' : 'اختيار متعدد';
  }
  if (pageKey === 'owners') renderOwnersSelectionCards();
  renderAuxRecordsPage(pageKey);
}

function toggleAuxColMenu(pageKey) {
  const state = auxRecordStates[pageKey];
  if (!state || !state.colMenu) return;
  const shouldOpen = !state.colMenu.classList.contains('open');
  document.querySelectorAll('.col-menu[data-aux-menu="1"]').forEach(m => m.classList.remove('open'));
  state.colMenu.classList.toggle('open', shouldOpen);
}

document.addEventListener('click', e => {
  if (!e.target.closest('.col-menu[data-aux-menu="1"]') && !e.target.closest('[onclick*="toggleAuxColMenu"]')) {
    document.querySelectorAll('.col-menu[data-aux-menu="1"]').forEach(m => m.classList.remove('open'));
  }
});

function toggleAuxCol(pageKey, key) {
  const state = auxRecordStates[pageKey];
  if (!state || !(key in state.colVisible)) return;
  state.colVisible[key] = !state.colVisible[key];
  applyAuxColumnVisibility(pageKey);
  // update the all-toggle indicator
  const allVisible = Object.values(state.colVisible).every(v => v);
  const allTog = document.getElementById(`${pageKey}-tog-all`);
  if (allTog) allTog.textContent = allVisible ? '✓' : '';
}

function toggleAuxColAll(pageKey) {
  const state = auxRecordStates[pageKey];
  if (!state) return;
  const allVisible = Object.values(state.colVisible).every(v => v);
  const newVal = !allVisible;
  Object.keys(state.colVisible).forEach(key => { state.colVisible[key] = newVal; });
  applyAuxColumnVisibility(pageKey);
  const allTog = document.getElementById(`${pageKey}-tog-all`);
  if (allTog) allTog.textContent = newVal ? '✓' : '';
}

function applyAuxColumnVisibility(pageKey) {
  const state = auxRecordStates[pageKey];
  if (!state) return;
  const cg = document.getElementById(`${pageKey}-colgroup`);
  Object.keys(state.colVisible).forEach(key => {
    const cls = 'col-' + key;
    const isVisible = !!state.colVisible[key];
    state.root.querySelectorAll('.' + cls).forEach(el => {
      el.style.display = isVisible ? '' : 'none';
    });
    if (cg) {
      const col = cg.querySelector('.' + cls);
      if (col) col.style.display = isVisible ? '' : 'none';
    }
    const mark = document.getElementById(`${pageKey}-tog-${key}`);
    if (mark) mark.textContent = isVisible ? '✓' : '';
  });
  syncAuxIdOnlyCompactLayout(pageKey);
  requestAnimationFrame(() => updateTableScrollStartButtons());
  requestAnimationFrame(() => applyColumnPinning(`${pageKey}-table`));
}

function syncAuxIdOnlyCompactLayout(pageKey) {
  const state = auxRecordStates[pageKey];
  if (!state || !state.table) return;
  const visibleKeys = Object.keys(state.colVisible).filter(key => !!state.colVisible[key]);
  const idKeys = new Set(['ownerId', 'signalId', 'attachmentId']);
  const idOnlyVisible = visibleKeys.length === 1 && idKeys.has(visibleKeys[0]);
  state.table.classList.toggle('id-only-compact', idOnlyVisible);
}

function applyAuxColumnOrder(pageKey) {
  const state = auxRecordStates[pageKey];
  if (!state || !state.table) return;
  const rows = state.table.querySelectorAll('thead tr, tbody tr:not(.detail-row)');
  rows.forEach(row => {
    const selectCell = row.querySelector('.select-col');
    const cellsByKey = new Map();
    state.columnOrder.forEach(cls => {
      const cell = row.querySelector('.' + cls);
      if (cell) cellsByKey.set(cls, cell);
    });
    if (selectCell) row.appendChild(selectCell);
    state.columnOrder.forEach(cls => {
      const cell = cellsByKey.get(cls);
      if (cell) row.appendChild(cell);
    });
  });
  const cg = document.getElementById(`${pageKey}-colgroup`);
  if (cg) {
    const selectCol = cg.querySelector('.select-col');
    const colsByKey = new Map();
    state.columnOrder.forEach(cls => {
      const col = cg.querySelector('.' + cls);
      if (col) colsByKey.set(cls, col);
    });
    if (selectCol) cg.appendChild(selectCol);
    state.columnOrder.forEach(cls => {
      const col = colsByKey.get(cls);
      if (col) cg.appendChild(col);
    });
  }
}

function setupAuxColumnReorderHandlers(pageKey) {
  const state = auxRecordStates[pageKey];
  if (!state || !state.table) return;
  const headers = Array.from(state.table.querySelectorAll('thead th[data-col-key]'));
  headers.forEach(th => {
    const key = th.dataset.colKey;
    if (!key) return;
    th.draggable = state.columnReorderMode;
    th.classList.toggle('col-drag', state.columnReorderMode);
    if (th.dataset.auxDndBound === '1') return;
    th.dataset.auxDndBound = '1';
    th.addEventListener('dragstart', e => {
      if (!state.columnReorderMode) return;
      state.draggedColumnKey = key;
      e.dataTransfer.effectAllowed = 'move';
      e.dataTransfer.setData('text/plain', key);
    });
    th.addEventListener('dragover', e => {
      if (!state.columnReorderMode) return;
      e.preventDefault();
      e.dataTransfer.dropEffect = 'move';
    });
    th.addEventListener('drop', e => {
      if (!state.columnReorderMode) return;
      e.preventDefault();
      const targetKey = key;
      const sourceKey = state.draggedColumnKey || e.dataTransfer.getData('text/plain');
      if (!sourceKey || !targetKey || sourceKey === targetKey) return;
      const from = state.columnOrder.indexOf(sourceKey);
      const to = state.columnOrder.indexOf(targetKey);
      if (from === -1 || to === -1) return;
      const [moved] = state.columnOrder.splice(from, 1);
      state.columnOrder.splice(to, 0, moved);
      renderAuxRecordsPage(pageKey);
    });
    th.addEventListener('dragend', () => {
      state.draggedColumnKey = null;
    });
  });
}

function toggleAuxColumnReorderMode(pageKey) {
  const state = auxRecordStates[pageKey];
  if (!state) return;
  state.columnReorderMode = !state.columnReorderMode;
  setupAuxColumnReorderHandlers(pageKey);
  if (state.reorderBtn) {
    state.reorderBtn.textContent = state.columnReorderMode ? '✓ وضع إعادة الترتيب' : '⇅ إعادة الترتيب';
  }
  if (state.columnReorderMode) {
    alert('وضع إعادة الترتيب مُفعّل: اسحب عنوان العمود وأفلته في المكان المطلوب.');
  }
}

function initAuxRecordsPage(pageKey, rootId) {
  const root = document.getElementById(rootId);
  const cfg = AUX_RECORDS_CONFIG[pageKey];
  if (!root || !cfg) return;
  const columns = getAuxColumnDefs(pageKey);
  const menuItems = `<div class="col-menu-pin-bar" id="${pageKey}-pin-actions"><button type="button" class="col-menu-unpin-btn" onclick="unpinAllColumns('${pageKey}-table')">إلغاء تثبيت الكل</button><span class="col-menu-pin-info"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="17" x2="12" y2="22"/><path d="M5 17h14v-1.76a2 2 0 0 0-1.11-1.79l-1.78-.9A2 2 0 0 1 15 10.76V6h1a2 2 0 0 0 0-4H8a2 2 0 0 0 0 4h1v4.76a2 2 0 0 1-1.11 1.79l-1.78.9A2 2 0 0 0 5 15.24Z"/></svg><span id="${pageKey}-pin-count"></span></span></div>` +
    `<div class="col-menu-item col-menu-selectall" onclick="toggleAuxColAll('${pageKey}')"><div class="col-toggle" id="${pageKey}-tog-all">✓</div> تحديد الكل</div>` +
    columns.map(c => `<div class="col-menu-item" onclick="toggleAuxCol('${pageKey}','${c.key}')"><div class="col-toggle" id="${pageKey}-tog-${c.key}">✓</div> ${c.label}</div>`).join('');

  const ownDateFilter = pageKey === 'owners' ? `
        <div class="filter-group">
          <span class="filter-group-title">تاريخ تملك العقار</span>
          <div class="date-range-dropdown">
            <button type="button" class="date-range-btn" id="${pageKey}-own-btn" onclick="toggleDateRangePopover('${pageKey}-own-pop', event)">
              <span id="${pageKey}-own-label">من — إلى</span>
              <span class="date-range-arrow">▾</span>
            </button>
            <div class="date-range-popover" id="${pageKey}-own-pop">
              <div class="date-range-popover-row">
                <span class="date-range-popover-label">من</span>
                <input class="search-input" id="${pageKey}-own-from" type="date" oninput="filterAuxRecords('${pageKey}');updateDateRangeLabel('${pageKey}-own-from','${pageKey}-own-to','${pageKey}-own-label','${pageKey}-own-btn')">
              </div>
              <div class="date-range-popover-row">
                <span class="date-range-popover-label">إلى</span>
                <input class="search-input" id="${pageKey}-own-to" type="date" oninput="filterAuxRecords('${pageKey}');updateDateRangeLabel('${pageKey}-own-from','${pageKey}-own-to','${pageKey}-own-label','${pageKey}-own-btn')">
              </div>
              <button class="date-range-clear" onclick="clearDateRange('${pageKey}-own-from','${pageKey}-own-to','${pageKey}-own-label','${pageKey}-own-btn');filterAuxRecords('${pageKey}')">✕ مسح</button>
            </div>
          </div>
        </div>` : '';

  root.innerHTML = `
    <div class="report-focus-target" id="${pageKey}-focus-target">
    <div class="table-toolbar">
      <div class="toolbar-main-actions">
        <button type="button" class="toolbar-main-btn search-icon-btn" id="${pageKey}-toolbar-main-search" onclick="setAuxToolbarMode('${pageKey}','search')" title="بحث" aria-label="بحث">🔍</button>
        <div class="toolbar-inline-search" id="${pageKey}-toolbar-inline-search">
          <input class="search-input" id="${pageKey}-search" placeholder="ابحث في جميع الحقول…" type="text" style="min-width:0">
          <button type="button" class="toolbar-search-close" onclick="setAuxToolbarMode('${pageKey}','close-search')" title="إغلاق البحث">✕</button>
        </div>
        <button type="button" class="toolbar-main-btn" id="${pageKey}-toolbar-main-reports" onclick="setAuxToolbarMode('${pageKey}','reports')">مولد تقارير</button>
        <div class="export-dropdown">
          <button type="button" class="toolbar-main-btn" id="${pageKey}-toolbar-main-export" onclick="toggleExportDropdown('${pageKey}-export-menu')">تصدير ▾</button>
          <div class="export-dropdown-menu" id="${pageKey}-export-menu">
            <button class="export-dropdown-item excel" type="button" onclick="exportAuxRecordsCSV('${pageKey}'); closeExportDropdown('${pageKey}-export-menu')">
              <svg width="13" height="13" viewBox="0 0 14 14" fill="none"><rect x="1" y="1" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M4 4l6 6M10 4L4 10" stroke="currentColor" stroke-width="1.5"/></svg>
              تصدير Excel
            </button>
            <button class="export-dropdown-item pdf" type="button" onclick="printRegistryTablePdf(); closeExportDropdown('${pageKey}-export-menu')">
              <svg width="13" height="13" viewBox="0 0 14 14" fill="none"><rect x="1" y="1" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M4 7h6M4 4h6M4 10h4" stroke="currentColor" stroke-width="1.5"/></svg>
              تصدير PDF
            </button>
          </div>
        </div>
        <button type="button" class="toolbar-main-btn" id="${pageKey}-fullscreen-btn" data-fullscreen-key="${pageKey}" onclick="toggleReportTableFullscreen('${pageKey}')">⛶ ملء الشاشة</button>
      </div>
      <div class="toolbar-mode-panel" id="${pageKey}-toolbar-reports-panel" hidden>
        <div class="filter-group">
          <span class="filter-group-title">توليد تقرير</span>
          <div style="position:relative">
            <button class="toolbar-btn toolbar-btn-report" type="button" onclick="toggleAuxColMenu('${pageKey}')">⚙ مولد التقارير</button>
            <div class="col-menu aux-col-menu-wide" id="${pageKey}-col-menu" data-aux-menu="1">${menuItems}</div>
          </div>
        </div>
        <div class="filter-group">
          <span class="filter-group-title">المدخل</span>
          <input class="search-input" id="${pageKey}-entered-by" placeholder="اسم المدخل…" type="text" style="min-width:0">
        </div>
        <div class="filter-group">
          <span class="filter-group-title">تاريخ الادخال</span>
          <div class="date-range-dropdown">
            <button type="button" class="date-range-btn" id="${pageKey}-created-btn" onclick="toggleDateRangePopover('${pageKey}-created-pop', event)">
              <span id="${pageKey}-created-label">من — إلى</span>
              <span class="date-range-arrow">▾</span>
            </button>
            <div class="date-range-popover" id="${pageKey}-created-pop">
              <div class="date-range-popover-row">
                <span class="date-range-popover-label">من</span>
                <input class="search-input" id="${pageKey}-from-date" type="date" oninput="filterAuxRecords('${pageKey}');updateDateRangeLabel('${pageKey}-from-date','${pageKey}-to-date','${pageKey}-created-label','${pageKey}-created-btn')">
              </div>
              <div class="date-range-popover-row">
                <span class="date-range-popover-label">إلى</span>
                <input class="search-input" id="${pageKey}-to-date" type="date" oninput="filterAuxRecords('${pageKey}');updateDateRangeLabel('${pageKey}-from-date','${pageKey}-to-date','${pageKey}-created-label','${pageKey}-created-btn')">
              </div>
              <button class="date-range-clear" onclick="clearDateRange('${pageKey}-from-date','${pageKey}-to-date','${pageKey}-created-label','${pageKey}-created-btn');filterAuxRecords('${pageKey}')">✕ مسح</button>
            </div>
          </div>
        </div>
        ${ownDateFilter}
        ${pageKey === 'owners' ? `
        <div class="filter-group">
          <span class="filter-group-title">العقار</span>
          <div class="filter-dropdown">
            <button type="button" class="filter-multi-btn" onclick="toggleOwnerCascadeMenu(event, '${pageKey}')" id="${pageKey}-cascade-btn">نوع العقار</button>
            <div class="cascade-menu" id="${pageKey}-cascade-menu">
              <div class="col-menu-item col-menu-selectall" onclick="toggleAllOwnerCascade(event,'${pageKey}')"><div class="col-toggle" id="${pageKey}-cascade-all">✓</div> تحديد الكل</div>
              <div class="cascade-sep"></div>
              <div class="cascade-item" onclick="toggleOwnerCascadeCat('أرض','${pageKey}',event)">
                <div class="cascade-item-left"><div class="col-toggle" id="${pageKey}-cascade-cat-أرض"></div> أرض</div>
                <span class="cascade-item-arrow">◂</span>
                <div class="cascade-submenu">
                  <div class="cascade-sub-item" onclick="toggleOwnerCascadeSub('زراعية','${pageKey}',event)"><div class="col-toggle" id="${pageKey}-cascade-sub-زراعية"></div> زراعية</div>
                  <div class="cascade-sub-item" onclick="toggleOwnerCascadeSub('سكنية','${pageKey}',event)"><div class="col-toggle" id="${pageKey}-cascade-sub-سكنية"></div> سكنية</div>
                </div>
              </div>
              <div class="cascade-item" onclick="toggleOwnerCascadeCat('سكن','${pageKey}',event)">
                <div class="cascade-item-left"><div class="col-toggle" id="${pageKey}-cascade-cat-سكن"></div> سكن</div>
                <span class="cascade-item-arrow">◂</span>
                <div class="cascade-submenu">
                  <div class="cascade-sub-item" onclick="toggleOwnerCascadeSub('منزل','${pageKey}',event)"><div class="col-toggle" id="${pageKey}-cascade-sub-منزل"></div> منزل</div>
                  <div class="cascade-sub-item" onclick="toggleOwnerCascadeSub('فيلا','${pageKey}',event)"><div class="col-toggle" id="${pageKey}-cascade-sub-فيلا"></div> فيلا</div>
                </div>
              </div>
              <div class="cascade-item" onclick="toggleOwnerCascadeCat('تجاري','${pageKey}',event)">
                <div class="cascade-item-left"><div class="col-toggle" id="${pageKey}-cascade-cat-تجاري"></div> تجاري</div>
                <span class="cascade-item-arrow">◂</span>
                <div class="cascade-submenu">
                  <div class="cascade-sub-item" onclick="toggleOwnerCascadeSub('مجمع','${pageKey}',event)"><div class="col-toggle" id="${pageKey}-cascade-sub-مجمع"></div> مجمع</div>
                  <div class="cascade-sub-item" onclick="toggleOwnerCascadeSub('دكان','${pageKey}',event)"><div class="col-toggle" id="${pageKey}-cascade-sub-دكان"></div> دكان</div>
                  <div class="cascade-sub-item" onclick="toggleOwnerCascadeSub('مول','${pageKey}',event)"><div class="col-toggle" id="${pageKey}-cascade-sub-مول"></div> مول</div>
                  <div class="cascade-sub-item" onclick="toggleOwnerCascadeSub('مطعم','${pageKey}',event)"><div class="col-toggle" id="${pageKey}-cascade-sub-مطعم"></div> مطعم</div>
                  <div class="cascade-sub-item" onclick="toggleOwnerCascadeSub('أخرى','${pageKey}',event)"><div class="col-toggle" id="${pageKey}-cascade-sub-أخرى"></div> أخرى</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="filter-group">
          <span class="filter-group-title">تاريخ آخر تعديل (المالك)</span>
          <div class="date-range-dropdown">
            <button type="button" class="date-range-btn" id="owners-updated-btn" onclick="toggleDateRangePopover('owners-updated-pop', event)">
              <span id="owners-updated-label">من — إلى</span>
              <span class="date-range-arrow">▾</span>
            </button>
            <div class="date-range-popover" id="owners-updated-pop">
              <div class="date-range-popover-row">
                <span class="date-range-popover-label">من</span>
                <input class="search-input" id="owners-updated-from" type="date" oninput="filterAuxRecords('owners');updateDateRangeLabel('owners-updated-from','owners-updated-to','owners-updated-label','owners-updated-btn')">
              </div>
              <div class="date-range-popover-row">
                <span class="date-range-popover-label">إلى</span>
                <input class="search-input" id="owners-updated-to" type="date" oninput="filterAuxRecords('owners');updateDateRangeLabel('owners-updated-from','owners-updated-to','owners-updated-label','owners-updated-btn')">
              </div>
              <button type="button" class="date-range-clear" onclick="clearDateRange('owners-updated-from','owners-updated-to','owners-updated-label','owners-updated-btn');filterAuxRecords('owners')">✕ مسح</button>
            </div>
          </div>
        </div>` : ''}
        ${pageKey === 'consultations' ? `
        <div class="filter-group">
          <span class="filter-group-title">نوع الإشارة</span>
          <div class="filter-dropdown">
            <button type="button" class="filter-multi-btn" onclick="toggleConsultSigMenu(event)" id="consult-sigtype-btn">نوع الإشارة</button>
            <div class="col-menu" id="consult-sigtype-menu"></div>
          </div>
        </div>
        <div class="filter-group">
          <span class="filter-group-title">تاريخ الإشارة</span>
          <div class="date-range-dropdown">
            <button type="button" class="date-range-btn" id="consult-signal-db" onclick="toggleDateRangePopover('consult-signal-pop', event)">
              <span id="consult-signal-lab">من — إلى</span>
              <span class="date-range-arrow">▾</span>
            </button>
            <div class="date-range-popover" id="consult-signal-pop">
              <div class="date-range-popover-row">
                <span class="date-range-popover-label">من</span>
                <input class="search-input" id="consult-signal-from" type="date" oninput="filterAuxRecords('consultations');updateDateRangeLabel('consult-signal-from','consult-signal-to','consult-signal-lab','consult-signal-db')">
              </div>
              <div class="date-range-popover-row">
                <span class="date-range-popover-label">إلى</span>
                <input class="search-input" id="consult-signal-to" type="date" oninput="filterAuxRecords('consultations');updateDateRangeLabel('consult-signal-from','consult-signal-to','consult-signal-lab','consult-signal-db')">
              </div>
              <button type="button" class="date-range-clear" onclick="clearDateRange('consult-signal-from','consult-signal-to','consult-signal-lab','consult-signal-db');filterAuxRecords('consultations')">✕ مسح</button>
            </div>
          </div>
        </div>
        <div class="filter-group">
          <span class="filter-group-title">تاريخ آخر تعديل (إشارة)</span>
          <div class="date-range-dropdown">
            <button type="button" class="date-range-btn" id="consult-updated-db" onclick="toggleDateRangePopover('consult-updated-pop', event)">
              <span id="consult-updated-lab">من — إلى</span>
              <span class="date-range-arrow">▾</span>
            </button>
            <div class="date-range-popover" id="consult-updated-pop">
              <div class="date-range-popover-row">
                <span class="date-range-popover-label">من</span>
                <input class="search-input" id="consult-updated-from" type="date" oninput="filterAuxRecords('consultations');updateDateRangeLabel('consult-updated-from','consult-updated-to','consult-updated-lab','consult-updated-db')">
              </div>
              <div class="date-range-popover-row">
                <span class="date-range-popover-label">إلى</span>
                <input class="search-input" id="consult-updated-to" type="date" oninput="filterAuxRecords('consultations');updateDateRangeLabel('consult-updated-from','consult-updated-to','consult-updated-lab','consult-updated-db')">
              </div>
              <button type="button" class="date-range-clear" onclick="clearDateRange('consult-updated-from','consult-updated-to','consult-updated-lab','consult-updated-db');filterAuxRecords('consultations')">✕ مسح</button>
            </div>
          </div>
        </div>` : ''}
        ${pageKey === 'attachments' ? `
        <div class="filter-group">
          <span class="filter-group-title">تاريخ الملحق</span>
          <div class="date-range-dropdown">
            <button type="button" class="date-range-btn" id="attach-date-db" onclick="toggleDateRangePopover('attach-date-pop', event)">
              <span id="attach-date-lab">من — إلى</span>
              <span class="date-range-arrow">▾</span>
            </button>
            <div class="date-range-popover" id="attach-date-pop">
              <div class="date-range-popover-row">
                <span class="date-range-popover-label">من</span>
                <input class="search-input" id="attach-date-from" type="date" oninput="filterAuxRecords('attachments');updateDateRangeLabel('attach-date-from','attach-date-to','attach-date-lab','attach-date-db')">
              </div>
              <div class="date-range-popover-row">
                <span class="date-range-popover-label">إلى</span>
                <input class="search-input" id="attach-date-to" type="date" oninput="filterAuxRecords('attachments');updateDateRangeLabel('attach-date-from','attach-date-to','attach-date-lab','attach-date-db')">
              </div>
              <button type="button" class="date-range-clear" onclick="clearDateRange('attach-date-from','attach-date-to','attach-date-lab','attach-date-db');filterAuxRecords('attachments')">✕ مسح</button>
            </div>
          </div>
        </div>
        <div class="filter-group">
          <span class="filter-group-title">تاريخ آخر تعديل (ملحق)</span>
          <div class="date-range-dropdown">
            <button type="button" class="date-range-btn" id="attach-updated-db" onclick="toggleDateRangePopover('attach-updated-pop', event)">
              <span id="attach-updated-lab">من — إلى</span>
              <span class="date-range-arrow">▾</span>
            </button>
            <div class="date-range-popover" id="attach-updated-pop">
              <div class="date-range-popover-row">
                <span class="date-range-popover-label">من</span>
                <input class="search-input" id="attach-updated-from" type="date" oninput="filterAuxRecords('attachments');updateDateRangeLabel('attach-updated-from','attach-updated-to','attach-updated-lab','attach-updated-db')">
              </div>
              <div class="date-range-popover-row">
                <span class="date-range-popover-label">إلى</span>
                <input class="search-input" id="attach-updated-to" type="date" oninput="filterAuxRecords('attachments');updateDateRangeLabel('attach-updated-from','attach-updated-to','attach-updated-lab','attach-updated-db')">
              </div>
              <button type="button" class="date-range-clear" onclick="clearDateRange('attach-updated-from','attach-updated-to','attach-updated-lab','attach-updated-db');filterAuxRecords('attachments')">✕ مسح</button>
            </div>
          </div>
        </div>` : ''}
        <div class="filter-group">
          <span class="filter-group-title">ترتيب الأعمدة</span>
          <button class="toolbar-btn toolbar-btn-outline" type="button" id="${pageKey}-reorder-cols-btn" onclick="toggleAuxColumnReorderMode('${pageKey}')">⇅ إعادة الترتيب</button>
        </div>
        <div class="filter-group">
          <span class="filter-group-title">تحديد الصفوف</span>
          <button class="toolbar-btn toolbar-btn-gold" type="button" id="${pageKey}-multi-select-btn" onclick="${pageKey === 'owners' ? '' : `toggleAuxMultiSelect('${pageKey}')`}">اختيار متعدد</button>
        </div>
      </div>
    </div>
    <div class="filter-chips" id="${pageKey}-filter-chips"></div>
    <div class="table-card registry-pdf-print-root">
      <div class="table-with-scroll-btn">
      <div class="tbl-top-scroll" id="${pageKey}-top-scroll"><div class="tbl-top-scroll-inner"></div></div>
      <div class="table-overflow" id="${pageKey}-overflow">
        <table class="big-table" id="${pageKey}-table">
          <colgroup id="${pageKey}-colgroup">
            <col class="select-col" style="width:1px">${columns.map(c => {
              const isId = c.key === 'ownerId' || c.key === 'signalId' || c.key === 'attachmentId';
              return `<col class="col-${c.key}" style="${isId ? 'width:110px; min-width:110px' : 'width:1px'}">`;
            }).join('')}
          </colgroup>
          <thead><tr><th class="select-col"><div class="th-inner"><input type="checkbox" id="${pageKey}-select-all" onclick="toggleAuxSelectAll('${pageKey}')"></div></th>${columns.map(c => `<th class="col-${c.key}" data-col-key="col-${c.key}"><div class="th-inner">${c.label}</div></th>`).join('')}</tr></thead>
          <tbody id="${pageKey}-tbody"></tbody>
        </table>
      </div>
      <div class="table-scroll-start-bar" aria-hidden="true"></div>
      <div class="tbl-nav-pill" id="${pageKey}-tbl-nav-pill" role="navigation" aria-label="التنقل في الجدول">
        <div class="tbl-nav-pill-inner">
          <button type="button" class="tbl-nav-pill-btn" onclick="tblNavGo(this,'right')" title="بداية الجدول" aria-label="بداية الجدول">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 17l-5-5 5-5"/><path d="M18 17l-5-5 5-5"/></svg>
            بداية الجدول
          </button>
          <div class="tbl-nav-pill-sep" aria-hidden="true"></div>
          <button type="button" class="tbl-nav-pill-btn" onclick="tblNavGo(this,'left')" title="نهاية الجدول" aria-label="نهاية الجدول">
            نهاية الجدول
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M13 17l5-5-5-5"/><path d="M6 17l5-5-5-5"/></svg>
          </button>
        </div>
      </div>
      </div>
      <div class="pagination">
        <div class="export-info">إجمالي الصفوف: <strong id="${pageKey}-row-count">0</strong> | المحدَّد: <strong id="${pageKey}-selected-count">0</strong></div>
      </div>
    </div>
    </div>
  `;
  auxRecordStates[pageKey] = {
    mode: 'none',
    columns,
    rows: cfg.data.map((r, idx) => Object.assign({ __id: `${pageKey}-${idx + 1}` }, r)),
    filteredRows: cfg.data.map((r, idx) => Object.assign({ __id: `${pageKey}-${idx + 1}` }, r)),
    expanded: new Set(),
    selectedRows: new Set(),
    multiSelectEnabled: false,
    colVisible: Object.fromEntries(columns.map(c => [c.key, true])),
    columnOrder: columns.map(c => 'col-' + c.key),
    columnReorderMode: false,
    draggedColumnKey: null,
    root,
    table: document.getElementById(`${pageKey}-table`),
    colgroup: document.getElementById(`${pageKey}-colgroup`),
    colMenu: document.getElementById(`${pageKey}-col-menu`),
    reorderBtn: document.getElementById(`${pageKey}-reorder-cols-btn`),
    multiSelectBtn: document.getElementById(`${pageKey}-multi-select-btn`),
    selectAllEl: document.getElementById(`${pageKey}-select-all`),
    searchBtn: document.getElementById(`${pageKey}-toolbar-main-search`),
    reportsBtn: document.getElementById(`${pageKey}-toolbar-main-reports`),
    exportBtn: document.getElementById(`${pageKey}-toolbar-main-export`),
    reportsPanel: document.getElementById(`${pageKey}-toolbar-reports-panel`),
    exportPanel: null,
    chipsWrap: document.getElementById(`${pageKey}-filter-chips`),
    searchInput: document.getElementById(`${pageKey}-search`),
    enteredByInput: document.getElementById(`${pageKey}-entered-by`),
    fromInput: document.getElementById(`${pageKey}-from-date`),
    toInput: document.getElementById(`${pageKey}-to-date`),
    ownFromInput: document.getElementById(`${pageKey}-own-from`) || null,
    ownToInput: document.getElementById(`${pageKey}-own-to`) || null,
    tbody: document.getElementById(`${pageKey}-tbody`),
    rowCountEl: document.getElementById(`${pageKey}-row-count`),
    selectedCountEl: document.getElementById(`${pageKey}-selected-count`)
  };
  const listenKeys = ['searchInput', 'enteredByInput', 'fromInput', 'toInput'];
  if (auxRecordStates[pageKey].ownFromInput) listenKeys.push('ownFromInput');
  if (auxRecordStates[pageKey].ownToInput)   listenKeys.push('ownToInput');
  listenKeys.forEach(k => {
    if (auxRecordStates[pageKey][k]) {
      auxRecordStates[pageKey][k].addEventListener('input', () => {
      if (k === 'searchInput') { globalSearch(auxRecordStates[pageKey][k].value); }
      else { filterAuxRecords(pageKey); }
    });
    }
  });
  setAuxToolbarMode(pageKey, 'none');
  renderAuxFilterChips(pageKey);
  renderAuxRecordsPage(pageKey);
  if (pageKey === 'consultations') setupConsultSigTypeMenu();
  // Inject pin buttons into this table's headers
  requestAnimationFrame(() => {
    const state = auxRecordStates[pageKey];
    if (state && state.table) injectPinButtons(state.table.parentElement);
  });
}
const DASHBOARD_FILTER_TITLES = {
  all: 'ال<span>إحصاءات</span>',
  financial: 'إحصاءات <span>مالية</span>',
  administrative: 'إحصاءات <span>إدارية</span>',
  general: 'إحصاءات <span>عامة</span>'
};
const DASHBOARD_FILTER_HERO = {
  all: { src: '/vendor/viewer/assets/output-onlinegiftools.gif', alt: 'صورة الإحصاءات العامة' },
  financial: { src: '/vendor/viewer/assets/money-reports.gif', alt: 'صورة الإحصاءات المالية' },
  administrative: { src: '/vendor/viewer/assets/law-report.gif', alt: 'صورة الإحصاءات الإدارية' },
  general: { src: '/vendor/viewer/assets/general-reports.gif', alt: 'صورة الإحصاءات العامة' }
};

let currentDashboardStatsFilter = 'all';

function applyDashboardStatsFilter(filter = 'all') {
  const validFilter = DASHBOARD_FILTER_TITLES[filter] ? filter : 'all';
  currentDashboardStatsFilter = validFilter;

  document.querySelectorAll('#page-dashboard .dashboard-block').forEach(block => {
    const cat = block.getAttribute('data-stats-category') || 'general';
    const show = validFilter === 'all' || cat === validFilter;
    block.style.display = show ? '' : 'none';
  });

  document.querySelectorAll('.nav-subitem[data-stats-filter]').forEach(el => {
    el.classList.toggle('active', el.getAttribute('data-stats-filter') === validFilter);
  });

  const heroImg = document.querySelector('#dashboard-hero img');
  const heroConfig = DASHBOARD_FILTER_HERO[validFilter] || DASHBOARD_FILTER_HERO.all;
  if (heroImg && heroConfig) {
    heroImg.src = heroConfig.src;
    heroImg.alt = heroConfig.alt;
  }
}

function getActivityEntries() {
  let stored = [];
  try {
    stored = JSON.parse(localStorage.getItem(ACTIVITY_LOG_KEY) || '[]');
  } catch (e) {
    stored = [];
  }
  if (!Array.isArray(stored)) stored = [];
  if (stored.length) {
    return stored
      .map(r => ({
        ts: r.ts || r.at || 0,
        kind: r.kind || r.type || 'تحديث',
        title: r.title || r.name || '',
        propNo: r.propNo || '',
        detail: r.detail || ''
      }))
      .sort((a, b) => b.ts - a.ts)
      .slice(0, 40);
  }
  return buildings
    .slice()
    .reverse()
    .map((b, i) => {
      const opsLine = Array.isArray(b.opsDetails) && b.opsDetails[0] ? String(b.opsDetails[0]) : '';
      return {
        ts: Date.now() - i * 7200000,
        kind: opsLine ? 'تعديل / عملية' : 'عقار',
        title: b.name,
        propNo: b.propNo,
        detail: opsLine || 'مسجّل ضمن بطاقات العقار (التقارير).'
      };
    });
}

function escapeActivityHtml(s) {
  return String(s)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

function renderActivityFeed() {
  const ul = document.getElementById('activity-feed-list');
  if (!ul) return;
  const rows = getActivityEntries().slice(0, 20);
  if (!rows.length) {
    ul.innerHTML =
      '<li class="activity-feed-item"><div class="activity-feed-detail" style="margin:0">لا توجد بيانات نشاط بعد.</div></li>';
    return;
  }
  ul.innerHTML = rows
    .map(r => {
      const d = new Date(r.ts);
      const dateStr = Number.isNaN(d.getTime())
        ? '—'
        : d.toLocaleString('ar-SA', { dateStyle: 'medium', timeStyle: 'short' });
      const propPart = r.propNo
        ? ` · <span style="color:var(--gold-mid)">${escapeActivityHtml(r.propNo)}</span>`
        : '';
      return `<li class="activity-feed-item">
        <div class="activity-feed-row">
          <span class="activity-feed-badge">${escapeActivityHtml(r.kind)}</span>
          <span class="activity-feed-meta">${escapeActivityHtml(dateStr)}</span>
        </div>
        <div class="activity-feed-title">${escapeActivityHtml(r.title)}${propPart}</div>
        <div class="activity-feed-detail">${escapeActivityHtml(r.detail)}</div>
      </li>`;
    })
    .join('');
}

window.logPropertyActivity = function logPropertyActivity(entry) {
  try {
    let arr = JSON.parse(localStorage.getItem(ACTIVITY_LOG_KEY) || '[]');
    if (!Array.isArray(arr)) arr = [];
    arr.unshift(Object.assign({ ts: Date.now() }, entry));
    localStorage.setItem(ACTIVITY_LOG_KEY, JSON.stringify(arr.slice(0, 80)));
  } catch (e) {}
};

function goToPage(id, options = {}) {
  const pageEl = document.getElementById('page-' + id);
  if (!pageEl) return;

  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  pageEl.classList.add('active');

  document.querySelectorAll('.sidebar-nav .nav-item').forEach(n => n.classList.remove('active'));
  document.querySelectorAll('.mobile-nav-btn.nav-item').forEach(n => n.classList.remove('active'));

  syncNavForPage(id);

  const titleEl = document.getElementById('topbar-title');
  if (id === 'dashboard') {
    applyDashboardStatsFilter(options.stats || 'all');
  } else {
    document.querySelectorAll('.nav-subitem[data-stats-filter]').forEach(el => el.classList.remove('active'));
  }

  if (titleEl) {
    const title = id === 'dashboard'
      ? (DASHBOARD_FILTER_TITLES[currentDashboardStatsFilter] || PAGE_TITLES.dashboard)
      : (PAGE_TITLES[id] || '');
    titleEl.innerHTML = title;
  }

  if (id === 'activity') renderActivityFeed();
  closeSidebarForMobile();
  syncPageTableScrollState(pageEl);
  updateTopbarHeightVar();
  updateTopbarHubShortcut(id);
}

/** إظهار وتمييز صف مستهدَف بعد الانتقال من تفاصيل موسّعة — يُستَدْعَى من الواجهات فقط عبر الإسناد */
function flashReportJumpTarget(el) {
  if (!el) return;
  el.classList.add('report-jump-highlight');
  setTimeout(() => el.classList.remove('report-jump-highlight'), 2600);
}

function pickAuxMainRow(pageKey, auxRid) {
  const sid = typeof CSS !== 'undefined' && CSS.escape ? CSS.escape(String(auxRid)) : String(auxRid).replace(/\\/g, '\\\\').replace(/"/g, '\\"');
  return document.querySelector(`#${pageKey}-table tbody tr.aux-main-row[data-aux-rid="${sid}"]`);
}

/** تمرير إلى صف أساسي في تقارير الملحق وجعل المقطع المفتوح يظهر (مثل ملاحظات، تفاصيل) */
function jumpLinked_scrollToAuxRow(pageKey, auxRid, expandSectionSuffix) {
  const state = auxRecordStates[pageKey];
  if (!state) return;
  if (expandSectionSuffix) state.expanded.add(`${auxRid}-${expandSectionSuffix}`);
  renderAuxRecordsPage(pageKey);
  requestAnimationFrame(() => {
    setTimeout(() => {
      const tr = pickAuxMainRow(pageKey, auxRid);
      if (tr) {
        tr.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        flashReportJumpTarget(tr);
      }
    }, 90);
  });
}

window.jumpLinkedRecord = function(kind, rawId, propertyExpandMaybe) {
  const id = String(rawId || '').trim();
  if (!id) return;
  const pe = typeof propertyExpandMaybe === 'string' ? propertyExpandMaybe : '';
  window.setTimeout(() => {
    try {
      if (kind === 'owner') jumpLinkedOwnerImpl(id);
      else if (kind === 'consultation') jumpLinkedConsultationImpl(id);
      else if (kind === 'attachment') jumpLinkedAttachmentImpl(id);
      else if (kind === 'property') jumpLinkedPropertyImpl(id, pe);
    } catch (err) {
      console.warn('[jumpLinkedRecord]', err);
    }
  }, 30);
};

function jumpLinkedOwnerImpl(ownerId) {
  goToPage('owners');
  ownerCascadeCats.owners.clear();
  ownerCascadeSubs.owners.clear();
  syncOwnerCascadeToggles('owners');
  updateOwnerCascadeLabel('owners');
  clearDateRange('owners-from-date', 'owners-to-date', 'owners-created-label', 'owners-created-btn');
  clearDateRange('owners-own-from', 'owners-own-to', 'owners-own-label', 'owners-own-btn');
  clearDateRange('owners-updated-from', 'owners-updated-to', 'owners-updated-label', 'owners-updated-btn');
  const entered = document.getElementById('owners-entered-by');
  if (entered) entered.value = '';
  const search = document.getElementById('owners-search');
  if (search) search.value = ownerId;
  filterAuxRecords('owners');
  const state = auxRecordStates.owners;
  let row = state.filteredRows.find(r => r.ownerId === ownerId);
  if (!row) {
    if (search) search.value = '';
    filterAuxRecords('owners');
    row = state.filteredRows.find(r => r.ownerId === ownerId) || state.rows.find(r => r.ownerId === ownerId);
  }
  if (!row) return;
  jumpLinked_scrollToAuxRow('owners', row.__id, 'ownNotes');
}

function jumpLinkedConsultationImpl(signalId) {
  goToPage('consultations');
  consultationSelectedSigTypes.clear();
  consultRefreshSigToggleMarks();
  updateConsultSigTypeBtnLabel();
  clearDateRange('consult-signal-from', 'consult-signal-to', 'consult-signal-lab', 'consult-signal-db');
  clearDateRange('consult-updated-from', 'consult-updated-to', 'consult-updated-lab', 'consult-updated-db');
  const ent = document.getElementById('consultations-entered-by');
  if (ent) ent.value = '';
  const search = document.getElementById('consultations-search');
  if (search) search.value = signalId;
  filterAuxRecords('consultations');
  const state = auxRecordStates.consultations;
  let row = state.filteredRows.find(r => r.signalId === signalId);
  if (!row) {
    if (search) search.value = '';
    filterAuxRecords('consultations');
    row = state.filteredRows.find(r => r.signalId === signalId) || state.rows.find(r => r.signalId === signalId);
  }
  if (!row) return;
  jumpLinked_scrollToAuxRow('consultations', row.__id, 'notes');
}

function jumpLinkedAttachmentImpl(attId) {
  goToPage('attachments');
  clearDateRange('attach-date-from', 'attach-date-to', 'attach-date-lab', 'attach-date-db');
  clearDateRange('attach-updated-from', 'attach-updated-to', 'attach-updated-lab', 'attach-updated-db');
  const ent = document.getElementById('attachments-entered-by');
  if (ent) ent.value = '';
  const search = document.getElementById('attachments-search');
  if (search) search.value = attId;
  filterAuxRecords('attachments');
  const state = auxRecordStates.attachments;
  let row = state.filteredRows.find(r => r.attachmentId === attId);
  if (!row) {
    if (search) search.value = '';
    filterAuxRecords('attachments');
    row = state.filteredRows.find(r => r.attachmentId === attId) || state.rows.find(r => r.attachmentId === attId);
  }
  if (!row) return;
  jumpLinked_scrollToAuxRow('attachments', row.__id, 'attdet');
}

function jumpLinkedPropertyImpl(propId, expandSection) {
  goToPage('properties');
  selectedOpStatusFilter.clear();
  selectedPaymentFinanceFilter.clear();
  syncPropOpMenuMarks();
  syncPropPayFinanceMenuMarks();
  selectedCountriesFilter.clear();
  selectedCitiesFilter.clear();
  selectedTypesFilter.clear();
  selectedSubTypesFilter.clear();
  selectedAreasFilter.clear();
  syncCascadeToggles();
  updateCascadeLabel();
  propCreatedFrom = propCreatedTo = propOwnFrom = propOwnTo = propEnteredBy = propUpdatedFrom = propUpdatedTo = '';
  ['prop-created-from', 'prop-created-to', 'prop-own-from', 'prop-own-to', 'prop-entered-by', 'prop-updated-from', 'prop-updated-to'].forEach(tid => {
    const z = document.getElementById(tid);
    if (z) z.value = '';
  });
  updateDateRangeLabel('prop-created-from', 'prop-created-to', 'prop-created-label', 'prop-created-btn');
  updateDateRangeLabel('prop-own-from', 'prop-own-to', 'prop-own-label', 'prop-own-btn');
  updateDateRangeLabel('prop-updated-from', 'prop-updated-to', 'prop-updated-label', 'prop-updated-btn');
  updateCountryLabel();
  updateCountryAllToggle();
  renderCityMenu();
  updateCityLabel();
  updateTypeLabel();
  updateTypeAllToggle();
  updateAreaLabel();
  updateAreaAllToggle();
  const search = document.getElementById('table-search');
  if (search) search.value = propId;
  propertyExpandedKeys = new Set();
  if (expandSection) propertyExpandedKeys.add(String(propId) + '\x1e' + expandSection);
  filterTable();
  requestAnimationFrame(() => {
    setTimeout(() => {
      const pidEsc = typeof CSS !== 'undefined' && CSS.escape ? CSS.escape(propId) : propId.replace(/\\/g, '\\\\').replace(/"/g, '\\"');
      const tr = document.querySelector(`#main-table tbody tr[data-prop-id="${pidEsc}"]:not(.detail-row)`);
      if (tr) {
        tr.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        flashReportJumpTarget(tr);
      }
    }, 90);
  });
}

function switchPageMobile(id) {
  goToPage(id);
}

function switchPage(id, btn) {
  goToPage(id);
}

function getReportFocusTarget(pageKey) {
  if (pageKey === 'properties') {
    return document.getElementById('properties-focus-target');
  }
  const state = auxRecordStates[pageKey];
  if (state && state.root) {
    return state.root.querySelector('.report-focus-target');
  }
  return document.getElementById(`${pageKey}-focus-target`);
}

function syncReportFullscreenButtons() {
  const activeEl = document.fullscreenElement || document.webkitFullscreenElement || null;
  const fullscreenIsReport = !!(activeEl && activeEl.classList && activeEl.classList.contains('report-focus-target'));
  document.body.classList.toggle('report-fullscreen-active', fullscreenIsReport);
  if (fullscreenIsReport) hideFloatingTableHead();
  document.querySelectorAll('[data-fullscreen-key]').forEach(btn => {
    const key = btn.getAttribute('data-fullscreen-key');
    const target = getReportFocusTarget(key);
    const isOpen = !!(target && activeEl === target);
    btn.textContent = isOpen ? '⤫ إغلاق الشاشة الكاملة' : '⛶ ملء الشاشة';
  });
}

function toggleReportTableFullscreen(pageKey) {
  const target = getReportFocusTarget(pageKey);
  if (!target) return;
  const activeEl = document.fullscreenElement || document.webkitFullscreenElement || null;
  const isOpen = activeEl === target;
  if (isOpen) {
    if (document.exitFullscreen) document.exitFullscreen();
    else if (document.webkitExitFullscreen) document.webkitExitFullscreen();
    return;
  }
  const request = target.requestFullscreen || target.webkitRequestFullscreen;
  if (request) request.call(target);
}

const MOBILE_SIDEBAR_QUERY = '(max-width: 1024px)';

function isMobileSidebarMode() {
  return window.matchMedia(MOBILE_SIDEBAR_QUERY).matches;
}

function closeSidebarForMobile() {
  if (isMobileSidebarMode()) {
    document.body.classList.remove('sidebar-open');
  }
}

function toggleSidebar() {
  if (isMobileSidebarMode()) {
    document.body.classList.toggle('sidebar-open');
    return;
  }
  // No-op on desktop — sidebar is now hover-controlled
}

function initSidebarState() {
  const mainContent = document.querySelector('.main-content');
  const applyForViewport = () => {
    if (isMobileSidebarMode()) {
      document.body.classList.remove('sidebar-open');
      document.body.classList.remove('sidebar-collapsed');
      return;
    }
    document.body.classList.remove('sidebar-open');
    // Desktop: always start collapsed; hover will expand it
    document.body.classList.add('sidebar-collapsed');
  };

  applyForViewport();
  window.addEventListener('resize', applyForViewport);

  // ── Hover-to-expand on desktop ──
  const sidebar = document.querySelector('.sidebar');
  if (!sidebar) return;

  let collapseTimer = null;

  sidebar.addEventListener('mouseenter', () => {
    if (isMobileSidebarMode()) return;
    if (collapseTimer) { clearTimeout(collapseTimer); collapseTimer = null; }
    document.body.classList.remove('sidebar-collapsed');
    startFloatingHeadTracking(650);
  });

  sidebar.addEventListener('mouseleave', () => {
    if (isMobileSidebarMode()) return;
    collapseTimer = setTimeout(() => {
      document.body.classList.add('sidebar-collapsed');
      startFloatingHeadTracking(650);
    }, 1000); // 1 second delay before collapsing
  });

  sidebar.addEventListener('transitionrun', () => startFloatingHeadTracking(650));
  sidebar.addEventListener('transitionend', () => requestFloatingTableHeadSync());
  if (mainContent) {
    mainContent.addEventListener('transitionrun', () => startFloatingHeadTracking(650));
    mainContent.addEventListener('transitionend', () => requestFloatingTableHeadSync());
  }
}

function updateTopbarHeightVar() {
  const topbar = document.querySelector('.topbar');
  const fallback = 72;
  const hTop = topbar ? Math.ceil(topbar.getBoundingClientRect().height) : fallback;
  let pin = Math.max(fallback, hTop + 6);

  const compactInnerTableScroll = typeof window.matchMedia === 'function'
    && window.matchMedia('(max-width: 600px)').matches;
  if (!compactInnerTableScroll) {
    const pageEl = document.querySelector('.page.active');
    const toolbarEl = pageEl ? pageEl.querySelector('.table-toolbar') : null;
    if (toolbarEl) {
      const cs = getComputedStyle(toolbarEl);
      if (cs.display !== 'none' && cs.visibility !== 'hidden') {
        const tRect = toolbarEl.getBoundingClientRect();
        const tH = Math.ceil(tRect.height || 0);
        const tTopParsed = parseFloat(cs.top);
        const tTop = Number.isFinite(tTopParsed) ? tTopParsed : 64;
        pin = Math.max(pin, Math.ceil(tTop + tH + 8));
      }
    }
  }

  document.documentElement.style.setProperty('--table-sticky-offset', `${pin}px`);
  requestFloatingTableHeadSync();
}

let floatingHeadRaf = 0;
let floatingHeadHost = null;
let floatingHeadTable = null;
let floatingHeadTrackRaf = 0;
let floatingHeadTrackUntil = 0;

function ensureFloatingHeadHost() {
  if (floatingHeadHost) return;
  floatingHeadHost = document.createElement('div');
  floatingHeadHost.className = 'floating-table-head';
  floatingHeadHost.setAttribute('aria-hidden', 'true');
  floatingHeadTable = document.createElement('table');
  floatingHeadHost.appendChild(floatingHeadTable);
  document.body.appendChild(floatingHeadHost);
}

function hideFloatingTableHead() {
  if (!floatingHeadHost) return;
  floatingHeadHost.style.display = 'none';
  floatingHeadHost.style.width = '';
  floatingHeadHost.style.left = '';
  floatingHeadTable.style.transform = '';
  floatingHeadTable.innerHTML = '';
}

function getActivePageEl() {
  return document.querySelector('.page.active');
}

function getFloatingHeadCandidate() {
  const activePage = getActivePageEl();
  if (!activePage) return null;
  const tables = Array.from(activePage.querySelectorAll('table.big-table, table.mini-table, table.mini-table-legal'));
  const stickyTop = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--table-sticky-offset')) || 72;
  for (const table of tables) {
    const thead = table.querySelector('thead');
    if (!thead) continue;
    const rect = table.getBoundingClientRect();
    if (rect.width < 10 || rect.height < 10) continue;
    const headRect = thead.getBoundingClientRect();
    const headerH = Math.max(28, Math.ceil(headRect.height || 32));
    const tableBottom = rect.bottom;
    const pinStartThreshold = stickyTop - 18;
    const shouldPin = headRect.top <= pinStartThreshold && tableBottom > (stickyTop + headerH + 2);
    if (!shouldPin) continue;
    const scrollBox = table.closest('.table-overflow') || table.parentElement;
    if (!scrollBox) continue;
    const boxRect = scrollBox.getBoundingClientRect();
    if (boxRect.width < 30) continue;
    return { table, thead, scrollBox, stickyTop, boxRect };
  }
  return null;
}

function updateFloatingTableHead() {
  ensureFloatingHeadHost();
  const candidate = getFloatingHeadCandidate();
  if (!candidate) {
    hideFloatingTableHead();
    return;
  }
  const { table, thead, scrollBox, stickyTop, boxRect } = candidate;
  const pageEl = table.closest('.page');
  const toolbarEl = pageEl ? pageEl.querySelector('.table-toolbar') : null;
  const coverRect = toolbarEl ? toolbarEl.getBoundingClientRect() : boxRect;
  const hostLeft = Math.round(Math.min(boxRect.left, coverRect.left));
  const hostRight = Math.round(Math.max(boxRect.right, coverRect.right));
  const hostWidth = Math.max(30, hostRight - hostLeft);
  const tableOffsetInsideHost = Math.round(boxRect.left - hostLeft);
  const headClone = thead.cloneNode(true);
  headClone.querySelectorAll('[id]').forEach(el => el.removeAttribute('id'));
  headClone.querySelectorAll('input, button, select, textarea, a').forEach(el => {
    el.setAttribute('tabindex', '-1');
    el.setAttribute('aria-hidden', 'true');
    if ('disabled' in el) el.disabled = true;
  });
  const sourceThs = Array.from(thead.querySelectorAll('th'));
  const cloneThs = Array.from(headClone.querySelectorAll('th'));
  cloneThs.forEach((th, i) => {
    const src = sourceThs[i];
    if (!src) return;
    const w = Math.ceil(src.getBoundingClientRect().width);
    const visible = getComputedStyle(src).display !== 'none';
    th.style.display = visible ? '' : 'none';
    th.style.width = `${w}px`;
    th.style.minWidth = `${w}px`;
    th.style.maxWidth = `${w}px`;
    th.style.boxSizing = 'border-box';
    th.style.position = 'static';
    th.style.top = 'auto';
  });
  floatingHeadTable.className = table.className;
  floatingHeadTable.id = '';
  floatingHeadTable.innerHTML = `<thead>${headClone.innerHTML}</thead>`;
  floatingHeadHost.style.display = 'block';
  floatingHeadHost.style.top = `${stickyTop}px`;
  floatingHeadHost.style.left = `${hostLeft}px`;
  floatingHeadHost.style.width = `${hostWidth}px`;
  floatingHeadTable.style.width = `${Math.round(table.scrollWidth)}px`;
  floatingHeadTable.style.minWidth = `${Math.round(table.scrollWidth)}px`;
  floatingHeadTable.style.transform = `translateX(${tableOffsetInsideHost - scrollBox.scrollLeft}px)`;
}

function requestFloatingTableHeadSync() {
  if (floatingHeadRaf) return;
  floatingHeadRaf = window.requestAnimationFrame(() => {
    floatingHeadRaf = 0;
    updateFloatingTableHead();
  });
}

function syncPageTableScrollState(pageEl) {
  if (!pageEl) return;
  const overflows = Array.from(pageEl.querySelectorAll('.table-overflow'));
  const hasInnerScroll = overflows.some(el => (el.scrollTop || 0) > 2);
  pageEl.classList.toggle('table-inner-scrolled', hasInnerScroll);
}

function syncAllPagesTableScrollState() {
  document.querySelectorAll('.page').forEach(syncPageTableScrollState);
}

/* ── Table nav pill logic ─────────────────────────────────────────── */
// Find the .table-overflow container from a button inside the pill
function tblNavFindScroller(btn) {
  let el = btn ? btn.parentElement : null;
  while (el && el !== document.documentElement) {
    if (el.classList && el.classList.contains('table-with-scroll-btn')) {
      return el.querySelector('.table-overflow');
    }
    el = el.parentElement;
  }
  return null;
}

function tblNavGetOverflow(tableKey) {
  return document.getElementById(tableKey + '-overflow');
}

// Physical-direction scroll: no RTL/LTR logic needed.
// scrollBy({left: +huge}) → browser clamps to physical RIGHT edge (shows rightmost columns)
// scrollBy({left: -huge}) → browser clamps to physical LEFT edge (shows leftmost columns)
function tblNavGo(btn, direction) {
  const scroller = tblNavFindScroller(btn);
  if (!scroller) return;
  if (scroller.scrollWidth <= scroller.clientWidth + 2) return;
  const smooth = !window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const behavior = smooth ? 'smooth' : 'auto';
  const HUGE = 999999;
  scroller.scrollBy({ left: direction === 'right' ? HUGE : -HUGE, behavior });
  if (typeof requestFloatingTableHeadSync === 'function') requestFloatingTableHeadSync();
  if (typeof startFloatingHeadTracking === 'function') startFloatingHeadTracking(500);
}

function updateTblNavPill(tableKey) {
  const pill = document.getElementById(tableKey + '-tbl-nav-pill');
  const el   = document.getElementById(tableKey + '-overflow');
  if (!pill || !el) return;
  pill.classList.toggle('visible', el.scrollWidth > el.clientWidth + 4);
}

function updateAllTblNavPills() {
  ['main', 'owners', 'consultations', 'attachments'].forEach(updateTblNavPill);
}

/* Legacy compat — keep old function name so any external calls don't break */
function scrollTableToStart(btn) {
  const wrap = btn && btn.closest('.table-with-scroll-btn');
  const el = wrap && wrap.querySelector('.table-overflow');
  if (!el) return;
  tblNavGo('main', 'start');
}
function updateTableScrollStartButtons() { updateAllTblNavPills(); }

/* Wire overflow scroll events → update nav pill dim states */
(function() {
  function wirePillListeners() {
    ['main', 'owners', 'consultations', 'attachments'].forEach(key => {
      const el = document.getElementById(key + '-overflow');
      if (!el || el.__tblNavWired) return;
      el.__tblNavWired = true;
      el.addEventListener('scroll', () => {
        updateTblNavPill(key);
        const topBar = document.getElementById(key + '-top-scroll');
        if (topBar) topBar.scrollLeft = el.scrollLeft;
      }, { passive: true });
      const topBar = document.getElementById(key + '-top-scroll');
      if (topBar) {
        const inner = topBar.querySelector('.tbl-top-scroll-inner');
        if (inner) inner.style.width = el.scrollWidth + 'px';
        topBar.addEventListener('scroll', () => { el.scrollLeft = topBar.scrollLeft; }, { passive: true });
      }
    });
    updateAllTblNavPills();
  }
  // Wire on load + re-check after page switches
  document.addEventListener('DOMContentLoaded', () => {
    setTimeout(wirePillListeners, 300);
    setTimeout(updateAllTblNavPills, 500);
  });
  // Also expose for goToPage to call
  window._wireTblNavPills = wirePillListeners;
})();

function startFloatingHeadTracking(durationMs = 500) {
  const until = Date.now() + durationMs;
  if (until > floatingHeadTrackUntil) floatingHeadTrackUntil = until;
  if (floatingHeadTrackRaf) return;
  const tick = () => {
    requestFloatingTableHeadSync();
    if (Date.now() < floatingHeadTrackUntil) {
      floatingHeadTrackRaf = window.requestAnimationFrame(tick);
    } else {
      floatingHeadTrackRaf = 0;
    }
  };
  floatingHeadTrackRaf = window.requestAnimationFrame(tick);
}

function handleLogout() {
  if (confirm('هل تريد تأكيد تسجيل الخروج من النظام؟')) {
    window.location.href = 'Login.html';
  }
}

/* ─── DATE & TIME ─── */
function updateTime() {
  const d = new Date();
  const timeStr = d.toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
  const el = document.getElementById('topbar-time');
  if (el) el.textContent = timeStr;
}

function toggleQuickSettings() {
  const fab = document.getElementById('qs-fab');
  const trig = document.getElementById('qs-fab-trigger');
  if (!fab) return;
  fab.classList.toggle('open');
  if (trig) trig.setAttribute('aria-expanded', fab.classList.contains('open') ? 'true' : 'false');
}

function closeQuickSettings() {
  const fab = document.getElementById('qs-fab');
  const trig = document.getElementById('qs-fab-trigger');
  if (fab) fab.classList.remove('open');
  if (trig) trig.setAttribute('aria-expanded', 'false');
}

document.addEventListener('click', function() {
  closeQuickSettings();
});

function setThemePref(t) {
  document.documentElement.setAttribute('data-theme', t);
  localStorage.setItem('themeMode', t);
  const p = getPrefs();
  p.theme = t;
  savePrefs(p);
  const d = document.getElementById('theme-dark-btn');
  const l = document.getElementById('theme-light-btn');
  if (d) d.classList.toggle('active', t === 'dark');
  if (l) l.classList.toggle('active', t === 'light');
  setFontColor(p.fontColor || 'default');
  setNavbarColor(p.navbarColor || 'default');
  setHeaderColor(p.headerColor || 'default');
  setTableColor(p.tableColor || 'default');
  setPanelColor(p.panelColor || 'plum');
}

function setFontSize(s) {
  const sizeMap = { normal: '15px', large: '17px', xl: '20px', xxl: '22px' };
  const sz = sizeMap[s] || '15px';
  document.documentElement.style.setProperty('--fs-base', sz);
  const p = getPrefs();
  p.fontSize = s;
  savePrefs(p);
  ['normal','large','xl','xxl'].forEach(k => {
    const btn = document.getElementById(`fs-${k}-btn`);
    if (btn) btn.classList.toggle('active', s === k);
  });
  refreshAfterPrefsChange();
}

function setCurrency(c) {
  const p = getPrefs();
  p.currency = c;
  savePrefs(p);
  const u = document.getElementById('cur-usd-btn');
  const lb = document.getElementById('cur-lbp-btn');
  const ae = document.getElementById('cur-aed-btn');
  if (u) u.classList.toggle('active', c === 'USD');
  if (lb) lb.classList.toggle('active', c === 'LBP');
  if (ae) ae.classList.toggle('active', c === 'AED');
  updateCurrencyRateUi(c);
  refreshAfterPrefsChange();
}

function setExchangeRate(rawValue) {
  const p = getPrefs();
  const selected = p.currency || 'USD';
  if (selected === 'USD') return;
  const parsed = Number(rawValue);
  if (!isFinite(parsed) || parsed <= 0) return;
  p.exchangeRates = p.exchangeRates || {};
  p.exchangeRates[selected] = parsed;
  savePrefs(p);
  updateCurrencyRateUi(selected);
  refreshAfterPrefsChange();
}

function setArea(a) {
  const p = getPrefs();
  p.area = a;
  savePrefs(p);
  const m = document.getElementById('area-m2-btn');
  const f = document.getElementById('area-ft2-btn');
  if (m) m.classList.toggle('active', a === 'm2');
  if (f) f.classList.toggle('active', a === 'ft2');
  refreshAfterPrefsChange();
}

function setOwnership(o) {
  const p = getPrefs();
  p.ownership = o;
  savePrefs(p);
  const s = document.getElementById('own-sahm-btn');
  const pc = document.getElementById('own-pct-btn');
  if (s) s.classList.toggle('active', o === 'sahm');
  if (pc) pc.classList.toggle('active', o === 'pct');
  refreshAfterPrefsChange();
}

function applyFont(f) {
  const fm = {
    Tajawal: "'Tajawal', sans-serif",
    Cairo: "'Cairo', sans-serif",
    Amiri: "'Amiri', serif"
  };
  const stack = fm[f] || fm.Tajawal;
  document.documentElement.style.setProperty('--font-body', stack);
  document.documentElement.style.setProperty('--font-ui', stack);
  document.documentElement.style.setProperty('--font-display', stack);
}

function setLang(l) {
  const p = getPrefs();
  p.lang = l;
  savePrefs(p);
  if (l === 'en') { window.location.href = 'index-en.html'; return; }
  const ar = document.getElementById('lang-ar-btn');
  const en = document.getElementById('lang-en-btn');
  if (ar) ar.classList.toggle('active', l === 'ar');
  if (en) en.classList.toggle('active', l === 'en');
  document.documentElement.setAttribute('lang', 'ar');
  document.documentElement.setAttribute('dir', 'rtl');
  document.body.setAttribute('dir', 'rtl');
}

function setFontColor(colorMode) {
  const p = getPrefs();
  p.fontColor = colorMode;
  savePrefs(p);

  const theme = document.documentElement.getAttribute('data-theme') || p.theme || 'dark';
  const palettes = {
    ivory: {
      dark: { primary: '#F5F0E8', secondary: '#DCCFB7', muted: '#B6A98E' },
      light: { primary: '#2D2418', secondary: '#645845', muted: '#867864' }
    },
    gold: {
      dark: { primary: '#E8C96A', secondary: '#D8B44F', muted: '#A48A46' },
      light: { primary: '#7A5B16', secondary: '#9B7522', muted: '#B08A3B' }
    },
    silver: {
      dark: { primary: '#E6EBF2', secondary: '#C6CEDB', muted: '#95A0B2' },
      light: { primary: '#2C3748', secondary: '#4C5A6F', muted: '#6B788B' }
    },
    mint: {
      dark: { primary: '#DDF8EE', secondary: '#AEE7D1', muted: '#79B79D' },
      light: { primary: '#1E5E4B', secondary: '#2F7861', muted: '#4A9078' }
    },
    rose: {
      dark: { primary: '#F8E5EC', secondary: '#E7BBCB', muted: '#B98297' },
      light: { primary: '#6A3245', secondary: '#8A4760', muted: '#A26179' }
    }
  };
  if (colorMode === 'default') {
    document.documentElement.style.removeProperty('--text-primary');
    document.documentElement.style.removeProperty('--text-secondary');
    document.documentElement.style.removeProperty('--text-muted');
  } else if (palettes[colorMode]) {
    const activePalette = palettes[colorMode][theme === 'light' ? 'light' : 'dark'];
    document.documentElement.style.setProperty('--text-primary', activePalette.primary);
    document.documentElement.style.setProperty('--text-secondary', activePalette.secondary);
    document.documentElement.style.setProperty('--text-muted', activePalette.muted);
  }

  ['default', 'ivory', 'gold', 'silver', 'mint', 'rose'].forEach(mode => {
    const btn = document.getElementById(`font-color-${mode}-btn`);
    if (btn) btn.classList.toggle('active', colorMode === mode);
  });
  refreshAfterPrefsChange();
}

function setNavbarColor(colorMode) {
  const p = getPrefs();
  p.navbarColor = colorMode;
  savePrefs(p);

  const theme = document.documentElement.getAttribute('data-theme') || p.theme || 'dark';
  const palettes = {
    obsidian: {
      dark: { surface: '#0F131A', border: '#283140', hoverBg: 'rgba(96,165,250,.10)', hoverBorder: 'rgba(96,165,250,.28)', activeBg: 'linear-gradient(135deg, rgba(96,165,250,.22), rgba(59,130,246,.10))', activeBorder: 'rgba(96,165,250,.42)', activeText: '#BFDBFE', bar: '#60A5FA' },
      light: { surface: '#EEF4FF', border: '#C4D7F5', hoverBg: 'rgba(59,130,246,.11)', hoverBorder: 'rgba(59,130,246,.27)', activeBg: 'linear-gradient(135deg, rgba(59,130,246,.18), rgba(96,165,250,.08))', activeBorder: 'rgba(59,130,246,.38)', activeText: '#1D4ED8', bar: '#2563EB' }
    },
    sand: {
      dark: { surface: '#21170F', border: '#4B3621', hoverBg: 'rgba(245,158,11,.10)', hoverBorder: 'rgba(245,158,11,.27)', activeBg: 'linear-gradient(135deg, rgba(245,158,11,.22), rgba(180,83,9,.09))', activeBorder: 'rgba(245,158,11,.4)', activeText: '#FCD34D', bar: '#F59E0B' },
      light: { surface: '#FFF6E7', border: '#E8D5B6', hoverBg: 'rgba(245,158,11,.11)', hoverBorder: 'rgba(217,119,6,.25)', activeBg: 'linear-gradient(135deg, rgba(245,158,11,.18), rgba(217,119,6,.08))', activeBorder: 'rgba(217,119,6,.36)', activeText: '#9A580A', bar: '#B45309' }
    },
    emerald: {
      dark: { surface: '#10231D', border: '#285246', hoverBg: 'rgba(52,211,153,.10)', hoverBorder: 'rgba(52,211,153,.27)', activeBg: 'linear-gradient(135deg, rgba(16,185,129,.22), rgba(4,120,87,.09))', activeBorder: 'rgba(52,211,153,.38)', activeText: '#86EFAC', bar: '#10B981' },
      light: { surface: '#EAFBF4', border: '#BFE8D5', hoverBg: 'rgba(16,185,129,.10)', hoverBorder: 'rgba(5,150,105,.24)', activeBg: 'linear-gradient(135deg, rgba(16,185,129,.16), rgba(5,150,105,.08))', activeBorder: 'rgba(5,150,105,.33)', activeText: '#065F46', bar: '#047857' }
    },
    royal: {
      dark: { surface: '#1A1430', border: '#3E3370', hoverBg: 'rgba(167,139,250,.10)', hoverBorder: 'rgba(167,139,250,.28)', activeBg: 'linear-gradient(135deg, rgba(139,92,246,.22), rgba(79,70,229,.10))', activeBorder: 'rgba(167,139,250,.42)', activeText: '#DDD6FE', bar: '#A78BFA' },
      light: { surface: '#F3F0FF', border: '#D6CCFA', hoverBg: 'rgba(139,92,246,.10)', hoverBorder: 'rgba(124,58,237,.24)', activeBg: 'linear-gradient(135deg, rgba(124,58,237,.17), rgba(99,102,241,.08))', activeBorder: 'rgba(124,58,237,.35)', activeText: '#5B21B6', bar: '#6D28D9' }
    },
    burgundy: {
      dark: { surface: '#2A141A', border: '#5C2936', hoverBg: 'rgba(244,114,182,.10)', hoverBorder: 'rgba(244,114,182,.28)', activeBg: 'linear-gradient(135deg, rgba(244,114,182,.22), rgba(190,24,93,.10))', activeBorder: 'rgba(244,114,182,.42)', activeText: '#FBCFE8', bar: '#F472B6' },
      light: { surface: '#FFF0F5', border: '#EDC9D6', hoverBg: 'rgba(236,72,153,.10)', hoverBorder: 'rgba(219,39,119,.24)', activeBg: 'linear-gradient(135deg, rgba(236,72,153,.17), rgba(190,24,93,.08))', activeBorder: 'rgba(219,39,119,.35)', activeText: '#9D174D', bar: '#BE185D' }
    }
  };

  if (colorMode === 'default') {
    document.documentElement.style.removeProperty('--nav-surface');
    document.documentElement.style.removeProperty('--nav-border');
    document.documentElement.style.removeProperty('--nav-hover-bg');
    document.documentElement.style.removeProperty('--nav-hover-border');
    document.documentElement.style.removeProperty('--nav-active-bg');
    document.documentElement.style.removeProperty('--nav-active-border');
    document.documentElement.style.removeProperty('--nav-active-text');
    document.documentElement.style.removeProperty('--nav-accent-bar');
  } else if (palettes[colorMode]) {
    const nav = palettes[colorMode][theme === 'light' ? 'light' : 'dark'];
    document.documentElement.style.setProperty('--nav-surface', nav.surface);
    document.documentElement.style.setProperty('--nav-border', nav.border);
    document.documentElement.style.setProperty('--nav-hover-bg', nav.hoverBg);
    document.documentElement.style.setProperty('--nav-hover-border', nav.hoverBorder);
    document.documentElement.style.setProperty('--nav-active-bg', nav.activeBg);
    document.documentElement.style.setProperty('--nav-active-border', nav.activeBorder);
    document.documentElement.style.setProperty('--nav-active-text', nav.activeText);
    document.documentElement.style.setProperty('--nav-accent-bar', nav.bar);
  }

  ['default', 'obsidian', 'sand', 'emerald', 'royal', 'burgundy'].forEach(mode => {
    const btn = document.getElementById(`nav-color-${mode}-btn`);
    if (btn) btn.classList.toggle('active', colorMode === mode);
  });
  refreshAfterPrefsChange();
}

function setHeaderColor(colorMode) {
  const p = getPrefs();
  p.headerColor = colorMode;
  savePrefs(p);

  const theme = document.documentElement.getAttribute('data-theme') || p.theme || 'dark';
  const palettes = {
    obsidian: {
      dark: { surface: 'rgba(12,18,28,.95)', border: '#2B3A52', accent: '#93C5FD', divider: 'linear-gradient(to left, rgba(147,197,253,.85), transparent 60%)', eyebrow: '#7FB3F4' },
      light: { surface: 'rgba(239,247,255,.95)', border: '#C8DAF3', accent: '#2563EB', divider: 'linear-gradient(to left, rgba(37,99,235,.65), transparent 60%)', eyebrow: '#346FC9' }
    },
    sand: {
      dark: { surface: 'rgba(36,24,14,.95)', border: '#5A422A', accent: '#FCD34D', divider: 'linear-gradient(to left, rgba(252,211,77,.85), transparent 60%)', eyebrow: '#E7BC58' },
      light: { surface: 'rgba(255,246,233,.95)', border: '#E8D2B2', accent: '#B45309', divider: 'linear-gradient(to left, rgba(180,83,9,.62), transparent 60%)', eyebrow: '#9B640F' }
    },
    emerald: {
      dark: { surface: 'rgba(14,34,28,.95)', border: '#2A584A', accent: '#6EE7B7', divider: 'linear-gradient(to left, rgba(110,231,183,.82), transparent 60%)', eyebrow: '#64D5A7' },
      light: { surface: 'rgba(235,250,243,.95)', border: '#C1E7D4', accent: '#047857', divider: 'linear-gradient(to left, rgba(4,120,87,.62), transparent 60%)', eyebrow: '#0B8A66' }
    },
    royal: {
      dark: { surface: 'rgba(24,18,42,.95)', border: '#473A77', accent: '#C4B5FD', divider: 'linear-gradient(to left, rgba(196,181,253,.82), transparent 60%)', eyebrow: '#AE99F4' },
      light: { surface: 'rgba(244,240,255,.95)', border: '#D8CCFA', accent: '#6D28D9', divider: 'linear-gradient(to left, rgba(109,40,217,.62), transparent 60%)', eyebrow: '#7B36E0' }
    },
    burgundy: {
      dark: { surface: 'rgba(39,18,24,.95)', border: '#663043', accent: '#F9A8D4', divider: 'linear-gradient(to left, rgba(249,168,212,.82), transparent 60%)', eyebrow: '#F28DBF' },
      light: { surface: 'rgba(255,241,247,.95)', border: '#EDCCDA', accent: '#BE185D', divider: 'linear-gradient(to left, rgba(190,24,93,.62), transparent 60%)', eyebrow: '#C02D68' }
    }
  };

  if (colorMode === 'default') {
    document.documentElement.style.removeProperty('--header-surface');
    document.documentElement.style.removeProperty('--header-border');
    document.documentElement.style.removeProperty('--header-title-accent');
    document.documentElement.style.removeProperty('--header-divider');
    document.documentElement.style.removeProperty('--header-eyebrow');
  } else if (palettes[colorMode]) {
    const h = palettes[colorMode][theme === 'light' ? 'light' : 'dark'];
    document.documentElement.style.setProperty('--header-surface', h.surface);
    document.documentElement.style.setProperty('--header-border', h.border);
    document.documentElement.style.setProperty('--header-title-accent', h.accent);
    document.documentElement.style.setProperty('--header-divider', h.divider);
    document.documentElement.style.setProperty('--header-eyebrow', h.eyebrow);
  }

  ['default', 'obsidian', 'sand', 'emerald', 'royal', 'burgundy'].forEach(mode => {
    const btn = document.getElementById(`header-color-${mode}-btn`);
    if (btn) btn.classList.toggle('active', colorMode === mode);
  });
  refreshAfterPrefsChange();
}

function setTableColor(colorMode) {
  const p = getPrefs();
  p.tableColor = colorMode;
  savePrefs(p);

  const theme = document.documentElement.getAttribute('data-theme') || p.theme || 'dark';
  const palettes = {
    obsidian: {
      dark: { surface: '#111827', border: '#334155', headBg: '#172033', headText: '#94A3B8', headHover: '#93C5FD', rowBorder: 'rgba(71,85,105,.65)', rowHoverBg: 'rgba(96,165,250,.08)', rowSelectedBg: 'rgba(96,165,250,.14)', rowSelectedBorder: 'rgba(96,165,250,.32)' },
      light: { surface: '#F8FBFF', border: '#CBDDF6', headBg: '#EAF2FF', headText: '#4F6688', headHover: '#2563EB', rowBorder: 'rgba(151,174,209,.62)', rowHoverBg: 'rgba(59,130,246,.08)', rowSelectedBg: 'rgba(59,130,246,.14)', rowSelectedBorder: 'rgba(59,130,246,.28)' }
    },
    sand: {
      dark: { surface: '#1F1810', border: '#5B452E', headBg: '#2A2016', headText: '#BEA789', headHover: '#F3C56C', rowBorder: 'rgba(121,94,61,.62)', rowHoverBg: 'rgba(245,158,11,.08)', rowSelectedBg: 'rgba(245,158,11,.14)', rowSelectedBorder: 'rgba(245,158,11,.3)' },
      light: { surface: '#FFF9EE', border: '#E8D7BC', headBg: '#FBF1DD', headText: '#876B42', headHover: '#B45309', rowBorder: 'rgba(205,180,141,.62)', rowHoverBg: 'rgba(180,83,9,.08)', rowSelectedBg: 'rgba(180,83,9,.14)', rowSelectedBorder: 'rgba(180,83,9,.28)' }
    },
    emerald: {
      dark: { surface: '#10211B', border: '#2C5848', headBg: '#162E25', headText: '#8DB9A8', headHover: '#6EE7B7', rowBorder: 'rgba(63,109,94,.62)', rowHoverBg: 'rgba(16,185,129,.08)', rowSelectedBg: 'rgba(16,185,129,.14)', rowSelectedBorder: 'rgba(16,185,129,.31)' },
      light: { surface: '#F1FBF6', border: '#C8E6D9', headBg: '#E2F5EC', headText: '#4F7D6D', headHover: '#047857', rowBorder: 'rgba(137,186,167,.62)', rowHoverBg: 'rgba(5,150,105,.08)', rowSelectedBg: 'rgba(5,150,105,.14)', rowSelectedBorder: 'rgba(5,150,105,.28)' }
    },
    royal: {
      dark: { surface: '#19152C', border: '#4A3C7C', headBg: '#211A38', headText: '#AFA0D9', headHover: '#C4B5FD', rowBorder: 'rgba(93,81,145,.62)', rowHoverBg: 'rgba(139,92,246,.08)', rowSelectedBg: 'rgba(139,92,246,.14)', rowSelectedBorder: 'rgba(167,139,250,.31)' },
      light: { surface: '#F7F2FF', border: '#DDCEF9', headBg: '#EFE6FF', headText: '#74639F', headHover: '#6D28D9', rowBorder: 'rgba(177,157,218,.62)', rowHoverBg: 'rgba(109,40,217,.08)', rowSelectedBg: 'rgba(109,40,217,.14)', rowSelectedBorder: 'rgba(109,40,217,.28)' }
    },
    burgundy: {
      dark: { surface: '#25141B', border: '#673548', headBg: '#301924', headText: '#C39AAF', headHover: '#F9A8D4', rowBorder: 'rgba(110,67,84,.62)', rowHoverBg: 'rgba(244,114,182,.08)', rowSelectedBg: 'rgba(244,114,182,.14)', rowSelectedBorder: 'rgba(244,114,182,.31)' },
      light: { surface: '#FFF4F8', border: '#EDCFDB', headBg: '#FDEAF1', headText: '#8C5D70', headHover: '#BE185D', rowBorder: 'rgba(205,154,177,.62)', rowHoverBg: 'rgba(190,24,93,.08)', rowSelectedBg: 'rgba(190,24,93,.14)', rowSelectedBorder: 'rgba(190,24,93,.28)' }
    }
  };

  if (colorMode === 'default') {
    document.documentElement.style.removeProperty('--table-surface');
    document.documentElement.style.removeProperty('--table-border');
    document.documentElement.style.removeProperty('--table-head-bg');
    document.documentElement.style.removeProperty('--table-head-text');
    document.documentElement.style.removeProperty('--table-head-hover');
    document.documentElement.style.removeProperty('--table-row-border');
    document.documentElement.style.removeProperty('--table-row-hover-bg');
    document.documentElement.style.removeProperty('--table-row-selected-bg');
    document.documentElement.style.removeProperty('--table-row-selected-border');
  } else if (palettes[colorMode]) {
    const tb = palettes[colorMode][theme === 'light' ? 'light' : 'dark'];
    document.documentElement.style.setProperty('--table-surface', tb.surface);
    document.documentElement.style.setProperty('--table-border', tb.border);
    document.documentElement.style.setProperty('--table-head-bg', tb.headBg);
    document.documentElement.style.setProperty('--table-head-text', tb.headText);
    document.documentElement.style.setProperty('--table-head-hover', tb.headHover);
    document.documentElement.style.setProperty('--table-row-border', tb.rowBorder);
    document.documentElement.style.setProperty('--table-row-hover-bg', tb.rowHoverBg);
    document.documentElement.style.setProperty('--table-row-selected-bg', tb.rowSelectedBg);
    document.documentElement.style.setProperty('--table-row-selected-border', tb.rowSelectedBorder);
  }

  ['default', 'obsidian', 'sand', 'emerald', 'royal', 'burgundy'].forEach(mode => {
    const btn = document.getElementById(`table-color-${mode}-btn`);
    if (btn) btn.classList.toggle('active', colorMode === mode);
  });
  refreshAfterPrefsChange();
}

function setPanelColor(colorMode) {
  const p = getPrefs();
  p.panelColor = colorMode;
  savePrefs(p);

  const theme = document.documentElement.getAttribute('data-theme') || p.theme || 'dark';
  const palettes = {
    slate: {
      dark:  { bg: '#1E2530', border: '#3A4558', head: '#1A2030' },
      light: { bg: '#EEF2F8', border: '#BCC8DC', head: '#E4EAF4' }
    },
    navy: {
      dark:  { bg: '#111A2E', border: '#2A3F6A', head: '#0D1526' },
      light: { bg: '#DDE8F8', border: '#96B8E8', head: '#C8D9F4' }
    },
    forest: {
      dark:  { bg: '#111E18', border: '#26432E', head: '#0D1A13' },
      light: { bg: '#D8F0E0', border: '#88C49A', head: '#C2E6CE' }
    },
    plum: {
      dark:  { bg: '#1E1428', border: '#3E2860', head: '#180F22' },
      light: { bg: '#EDE0F8', border: '#C4A0E0', head: '#E0CDF4' }
    },
    stone: {
      dark:  { bg: '#1E1C18', border: '#3D3830', head: '#191712' },
      light: { bg: '#EDE8DE', border: '#C0AE90', head: '#E2D9C8' }
    },
    rose: {
      dark:  { bg: '#241420', border: '#5C2845', head: '#1C0D19' },
      light: { bg: '#F8E4EE', border: '#DDA0BF', head: '#F2D0E4' }
    },
    teal: {
      dark:  { bg: '#0F1E20', border: '#1E4A50', head: '#0A1618' },
      light: { bg: '#D8F0EE', border: '#80C8C4', head: '#C0E6E4' }
    },
    gold: {
      dark:  { bg: '#201A0A', border: '#5A4510', head: '#181200' },
      light: { bg: '#FDF3D8', border: '#D4AF5A', head: '#F8E8B8' }
    }
  };

  if (colorMode === 'default') {
    document.documentElement.style.removeProperty('--qs-panel-bg');
    document.documentElement.style.removeProperty('--qs-panel-border');
    document.documentElement.style.removeProperty('--qs-panel-head-bg');
  } else if (palettes[colorMode]) {
    const c = palettes[colorMode][theme === 'light' ? 'light' : 'dark'];
    document.documentElement.style.setProperty('--qs-panel-bg', c.bg);
    document.documentElement.style.setProperty('--qs-panel-border', c.border);
    document.documentElement.style.setProperty('--qs-panel-head-bg', c.head);
  }

  ['default', 'slate', 'navy', 'forest', 'plum', 'stone', 'rose', 'teal', 'gold'].forEach(mode => {
    const btn = document.getElementById(`panel-color-${mode}-btn`);
    if (btn) btn.classList.toggle('active', colorMode === mode);
  });
  refreshAfterPrefsChange();
}

function resetAllSettings() {
  const defaults = {
    theme: 'dark',
    fontSize: 'normal',
    currency: 'USD',
    area: 'm2',
    ownership: 'sahm',
    fontFamily: 'Tajawal',
    lang: 'ar',
    fontColor: 'default',
    navbarColor: 'default',
    headerColor: 'default',
    tableColor: 'default',
    panelColor: 'plum'
  };
  savePrefs(defaults);
  setThemePref(defaults.theme);
  setFontSize(defaults.fontSize);
  setCurrency(defaults.currency);
  setArea(defaults.area);
  setOwnership(defaults.ownership);
  applyFont(defaults.fontFamily);
  document.querySelectorAll('[name="fontFamily"]').forEach(r => { r.checked = r.value === defaults.fontFamily; });
  setFontColor(defaults.fontColor);
  setNavbarColor(defaults.navbarColor);
  setHeaderColor(defaults.headerColor);
  setTableColor(defaults.tableColor);
  setPanelColor(defaults.panelColor);
  if (typeof setLang === 'function') setLang(defaults.lang);
  refreshAfterPrefsChange();
}

function bindQuickSettingsFontRadios() {
  if (window.__qsFontBound) return;
  window.__qsFontBound = true;
  document.querySelectorAll('[name="fontFamily"]').forEach(r => {
    r.addEventListener('change', function() {
      applyFont(this.value);
      const p = getPrefs();
      p.fontFamily = this.value;
      savePrefs(p);
      refreshAfterPrefsChange();
    });
  });
}

function loadPortfolioPrefs() {
  window.__prefsHydrating = true;
  bindQuickSettingsFontRadios();
  const p = getPrefs();
  const t = localStorage.getItem('themeMode') || p.theme || 'dark';
  setThemePref(t);
  if (p.fontSize) setFontSize(p.fontSize);
  else setFontSize('normal');
  if (p.currency) setCurrency(p.currency);
  else setCurrency('USD');
  if (p.area) setArea(p.area);
  else setArea('m2');
  if (p.ownership) setOwnership(p.ownership);
  else setOwnership('sahm');
  if (p.fontFamily) {
    applyFont(p.fontFamily);
    document.querySelectorAll('[name="fontFamily"]').forEach(r => {
      r.checked = r.value === p.fontFamily;
    });
  }
  if (p.lang) setLang(p.lang);
  if (p.fontColor) setFontColor(p.fontColor);
  else setFontColor('default');
  if (p.navbarColor) setNavbarColor(p.navbarColor);
  else setNavbarColor('default');
  if (p.headerColor) setHeaderColor(p.headerColor);
  else setHeaderColor('default');
  if (p.tableColor) setTableColor(p.tableColor);
  else setTableColor('default');
  if (p.panelColor) setPanelColor(p.panelColor);
  else setPanelColor('plum');
  updateCurrencyRateUi(p.currency || 'USD');
  window.__prefsHydrating = false;
}

(function() {
  const d = new Date();
  const opts = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
  document.getElementById('topbar-date').textContent = d.toLocaleDateString('ar-SA', opts);
  updateTime();
  setInterval(updateTime, 1000);
})();

/* ─── DASHBOARD HERO PARALLAX ─── */
(function() {
  const hero = document.getElementById('dashboard-hero');
  if (!hero) return;
  const visual = hero.querySelector('img, svg');
  const layers = Array.from(hero.querySelectorAll('.page-hero-layer'));

  function handleMove(e) {
    const rect = hero.getBoundingClientRect();
    const x = (e.clientX - rect.left) / rect.width - 0.5;  // -0.5 .. 0.5
    const y = (e.clientY - rect.top) / rect.height - 0.5;

    const rotateY = x * 10; // يمين / يسار
    const rotateX = -y * 8; // أعلى / أسفل
    if (visual) {
      visual.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
    }

    layers.forEach(layer => {
      const depth = parseFloat(layer.getAttribute('data-depth') || '1');
      const tx = -x * depth * 6;
      const ty = -y * depth * 4;
      layer.style.transform = `translate(${tx}px, ${ty}px)`;
    });
  }

  function reset() {
    if (visual) {
      visual.style.transform = 'rotateX(0deg) rotateY(0deg)';
    }
    layers.forEach(layer => {
      layer.style.transform = 'translate(0,0)';
    });
  }

  hero.addEventListener('mousemove', handleMove);
  hero.addEventListener('mouseleave', reset);
})();

/* ─── NEW STATS RENDER ─── */
function renderNewOverviewStats() {
  // ── عدد الدول ──
  const countries = [...new Set(buildings.map(b => b.country || b.دولة || '').filter(Boolean))];
  const countriesCount = countries.length || 4;
  const elC = document.getElementById('stat-countries-count');
  if (elC) elC.textContent = countriesCount;

  // ── عدد المدن ──
  const cities = [...new Set(buildings.map(b => b.city || b.مدينة || b.محافظة || '').filter(Boolean))];
  const citiesCount = cities.length || 8;
  const elCi = document.getElementById('stat-cities-count');
  if (elCi) elCi.textContent = citiesCount;

  // ── عدد الأراضي وأنواعها (من بيانات الجدول) ──
  const landTypeCounts = { residential: 0, commercial: 0, agricultural: 0, industrial: 0, other: 0 };
  buildings.forEach((b, idx) => {
    const category = String(getPropertyKindOfBuilding(b, idx) || '').trim().toLowerCase();
    const subType = String(getPropertySubTypeOfBuilding(b, idx) || '').trim().toLowerCase();
    const fallbackType = String(b.type || b.نوع || '').trim().toLowerCase();
    const sourceType = subType || fallbackType;
    const isLand = category.includes('أرض') || category.includes('ارض') || sourceType.includes('أرض') || sourceType.includes('ارض');
    if (!isLand) return;
    if (sourceType.includes('سكن')) landTypeCounts.residential += 1;
    else if (sourceType.includes('تجار')) landTypeCounts.commercial += 1;
    else if (sourceType.includes('زراع')) landTypeCounts.agricultural += 1;
    else if (sourceType.includes('صناع')) landTypeCounts.industrial += 1;
    else landTypeCounts.other += 1;
  });
  const landTotal =
    landTypeCounts.residential +
    landTypeCounts.commercial +
    landTypeCounts.agricultural +
    landTypeCounts.industrial +
    landTypeCounts.other;
  function setLandStat(countId, pctId, value, label) {
    const countEl = document.getElementById(countId);
    if (countEl) countEl.textContent = String(value);
    const pctEl = document.getElementById(pctId);
    if (pctEl) {
      const pct = landTotal > 0 ? Math.round((value / landTotal) * 100) : 0;
      pctEl.style.width = pct + '%';
      pctEl.textContent = pct > 0 ? `${label} ${pct}%` : label;
    }
  }
  setLandStat('stat-land-residential', 'stat-land-residential-pct', landTypeCounts.residential, 'سكني');
  setLandStat('stat-land-commercial', 'stat-land-commercial-pct', landTypeCounts.commercial, 'تجاري');
  setLandStat('stat-land-agricultural', 'stat-land-agricultural-pct', landTypeCounts.agricultural, 'زراعي');
  setLandStat('stat-land-industrial', 'stat-land-industrial-pct', landTypeCounts.industrial, 'صناعي');
  setLandStat('stat-land-other', 'stat-land-other-pct', landTypeCounts.other, 'أخرى');

  // ── عدد المشتريات في آخر سنتين ──
  const twoYearsAgo = Date.now() - (2 * 365 * 24 * 60 * 60 * 1000);
  const recentCount = buildings.filter(b => {
    const d = b.purchaseDate || b.تاريخ_الشراء || b.dateAdded || 0;
    return (typeof d === 'number' ? d : new Date(d).getTime()) >= twoYearsAgo;
  }).length;
  const elRecent = document.getElementById('stat-recent-count');
  if (elRecent) elRecent.textContent = recentCount ? recentCount + ' عقار' : buildings.length + ' عقار';

  // ── المالكون ──
  let ownersTotal = 0;
  try {
    const stored = JSON.parse(localStorage.getItem('ownersData') || '[]');
    ownersTotal = Array.isArray(stored) ? stored.length : 0;
  } catch(e) {}
  if (!ownersTotal) {
    try {
      const stored2 = JSON.parse(localStorage.getItem('owners') || '[]');
      ownersTotal = Array.isArray(stored2) ? stored2.length : 0;
    } catch(e) {}
  }
  const elOwn = document.getElementById('admin-kpi-owners-total');
  if (elOwn) elOwn.textContent = ownersTotal || '—';
  const elOwnMain = document.getElementById('admin-kpi-owners-main');
  if (elOwnMain) elOwnMain.textContent = ownersTotal ? Math.ceil(ownersTotal * 0.5) : '—';
  const elOwnShared = document.getElementById('admin-kpi-owners-shared');
  if (elOwnShared) elOwnShared.textContent = ownersTotal ? Math.ceil(ownersTotal * 0.3) : '—';
  const elOwnHeirs = document.getElementById('admin-kpi-owners-heirs');
  if (elOwnHeirs) elOwnHeirs.textContent = ownersTotal ? Math.floor(ownersTotal * 0.15) : '—';
  const elOwnOther = document.getElementById('admin-kpi-owners-other');
  if (elOwnOther) elOwnOther.textContent = ownersTotal ? Math.floor(ownersTotal * 0.05) : '—';

  // ── المدخلون (from legal KPI if present) ──
  const legalUsers = document.getElementById('legal-kpi-users');
  const adminUsersTotal = document.getElementById('admin-kpi-users-total');
  const adminUsersActive = document.getElementById('admin-kpi-users-active');
  const adminUsersInactive = document.getElementById('admin-kpi-users-inactive');
  if (legalUsers && adminUsersTotal) {
    const val = parseInt(legalUsers.textContent) || 0;
    adminUsersTotal.textContent = val || '—';
    if (val) {
      if (adminUsersActive) adminUsersActive.textContent = Math.ceil(val * 0.8);
      if (adminUsersInactive) adminUsersInactive.textContent = Math.floor(val * 0.2);
    }
  }
}

/* ─── INIT ─── */
let __openedFromStoredStartPage = false;
loadPortfolioPrefs();
initPropertyTableView();
initSidebarState();
try {
  const startPage = localStorage.getItem('startPage');
  if (startPage) {
    localStorage.removeItem('startPage');
    __openedFromStoredStartPage = true;
    const normalizedStartPage = (startPage === 'dashboard')
      ? 'stats-home'
      : (startPage === 'properties' ? 'reports-home' : startPage);
    goToPage(normalizedStartPage);
  }
} catch (e) {}
updateTopbarHeightVar();
window.addEventListener('resize', updateTopbarHeightVar);
window.addEventListener('orientationchange', updateTopbarHeightVar);
window.addEventListener('resize', updateTableScrollStartButtons);
window.addEventListener('scroll', requestFloatingTableHeadSync, { passive: true });
document.addEventListener('scroll', requestFloatingTableHeadSync, true);
document.addEventListener('scroll', e => {
  const target = e.target;
  if (!target || !target.classList || !target.classList.contains('table-overflow')) return;
  const pageEl = target.closest('.page');
  syncPageTableScrollState(pageEl);
  updateTableScrollStartButtons();
  if (typeof updateAllTblNavPills === 'function') updateAllTblNavPills();
  if (typeof window._wireTblNavPills === 'function') window._wireTblNavPills();
}, true);
window.addEventListener('resize', () => startFloatingHeadTracking(500));
updateCountryLabel();
renderCityMenu();
updateCityLabel();
updateTypeLabel();
updateAreaLabel();
hydrateBuildingPortalFields();
renderFinancialOverviewStats();
renderLegalOverviewCharts();
renderLegalRequestedCharts();
renderGeneralOverviewCharts();
renderNewOverviewStats();
renderTable();
if (!__openedFromStoredStartPage) goToPage('properties');
renderActiveFilterChips();
renderSelectionCard(filteredData, 'جميع العقارات');
initAuxRecordsPage('owners', 'owners-records-root');
renderOwnersSelectionCards();
initAuxRecordsPage('consultations', 'consultations-records-root');
initAuxRecordsPage('attachments', 'attachments-records-root');
statsGeneratorPopulateFields();
applyDashboardStatsFilter('all');
(function syncInitialNavChrome() {
  const activePage = document.querySelector('.page.active');
  const pid = activePage && activePage.id && activePage.id.startsWith('page-')
    ? activePage.id.slice(5)
    : 'stats-home';
  syncNavForPage(pid);
  updateTopbarHubShortcut(pid);
})();
setPropertyToolbarMode('none');
syncAllPagesTableScrollState();
requestFloatingTableHeadSync();
updateTableScrollStartButtons();
document.addEventListener('fullscreenchange', syncReportFullscreenButtons);
document.addEventListener('webkitfullscreenchange', syncReportFullscreenButtons);
syncReportFullscreenButtons();

/* ═══════════════════════════════════════════════════════════════
   مخططات الإحصاءات — محرك الرسوم البيانية الديناميكية
   ═══════════════════════════════════════════════════════════════ */
(function () {
  'use strict';

  /* ── ألوان ذهبية ── */
  const GC = ['#D4AF37','#C49A2A','#8B6914','#E8C96A','#A07820','#6B5E4A','#F5E9C0','#9B7D25'];
  const CC = { 'سكن':'#D4AF37','تجاري':'#C49A2A','أرض':'#8B6914' };

  /* ── عملة القسم المالي + أرقام عربية واضحة (٬ آلاف ، ٫ عشري) دون اعتماد لغة المتصفّح فقط ── */
  var FIN_CCY_CODE = 'USD';
  var FIN_CCY_AR = 'دولار أمريكي';
  var CHART_AXIS_STROKE = 'rgba(8,10,14,.94)';
  var CHART_AXIS_FILL = '#ebe4d6';
  var FIN_AXIS_STROKE = 'rgba(212,175,55,.75)';
  var FIN_GRID_STROKE = 'rgba(148,163,184,.1)';

  function wrapFinancialChart(inner) {
    return '<div class="fin-chart-frame" lang="ar" dir="rtl">' + inner + '</div>';
  }

  function toEasternArabicDigits(str) {
    return String(str).replace(/\d/g, function (d) {
      return '٠١٢٣٤٥٦٧٨٩'[+d];
    });
  }

  /** تجميع الآلاف بـ٬ والكسور بـ٫ مع أرقام هندية شرقية (بدون الغموض بين الفاصلة الأوروبية والعشرية). */
  function arNums(n, opt) {
    opt = opt || {};
    var maxFD = opt.maximumFractionDigits != null ? opt.maximumFractionDigits : 6;
    var minFD = opt.minimumFractionDigits != null ? opt.minimumFractionDigits : 0;
    var x = Number(n);
    if (!isFinite(x)) return '٠';
    var neg = x < 0;
    x = Math.abs(x);
    var rounded =
      maxFD <= 0
        ? Math.round(x)
        : Math.round(x * Math.pow(10, maxFD)) / Math.pow(10, maxFD);
    var intRaw,
      decRaw = '';
    if (maxFD <= 0) {
      intRaw = String(rounded);
    } else {
      var p = rounded.toFixed(maxFD).split('.');
      intRaw = p[0] || '0';
      decRaw = p[1] || '';
      while (decRaw.length > minFD && decRaw.slice(-1) === '0') decRaw = decRaw.slice(0, -1);
    }
    var intGrouped = intRaw.replace(/\B(?=(\d{3})+(?!\d))/g, '\u066C');
    var body = toEasternArabicDigits(intGrouped);
    if (decRaw.length > 0)
      body += '\u066B\u2009' + toEasternArabicDigits(decRaw);
    return (neg ? '\u2212' : '') + body;
  }

  /** مبالغ مختصرة للمحاور والجداول: $ بدل USD، م بدل مليون، ك بدل ألف */
  function fK(n) {
    var ccy = '$';
    var tail = '\u202F' + ccy;
    if (!isFinite(n) || n === 0) return '٠' + tail;
    if (n >= 1e6) {
      var mv = n / 1e6;
      var mRound = mv >= 100 ? Math.round(mv) : Math.round(mv * 10) / 10;
      return (
        arNums(mRound, { maximumFractionDigits: 2, minimumFractionDigits: 0 }) + '\u202Fم\u202F' + ccy
      );
    }
    if (n >= 1e3)
      return arNums(Math.round(n / 1e3), { maximumFractionDigits: 0 }) + '\u202Fك\u202F' + ccy;
    return arNums(Math.round(n), { maximumFractionDigits: 0 }) + tail;
  }

  function chartAxisFmt(v, currency) {
    return currency ? fK(v) : arNums(Math.round(v), { maximumFractionDigits: 0 });
  }

  /** عزل اتجاه نص المحور في SVG؛ بدون ذلك يخطئ text-anchor وتداخل التسميات منطقة الرسم مع العربية RTL. */
  function svgTickBidi(inner, currency) {
    var iso = currency ? '\u2067' : '\u2066';
    return iso + inner + '\u2069';
  }

  /** تسميات محور Y — حد رفيع فقط لتفادي مظهر النصّ «المضاعف». */
  function svgAxisTickText(x, y, inner) {
    return (
      '<text x="' +
      x +
      '" y="' +
      y +
      '" dominant-baseline="middle" text-anchor="end"' +
      ' font-size="10.5" font-weight="600" font-family="Tajawal,Segoe UI,sans-serif"' +
      ' fill="' +
      CHART_AXIS_FILL +
      '" stroke="' +
      CHART_AXIS_STROKE +
      '" stroke-width="1.25"' +
      ' paint-order="stroke fill">' +
      inner +
      '</text>'
    );
  }

  /**
   * أرقام محور القيمة ($) — يجب أن تبقى بكاملها يمين العنوان المائل ويسار خط المحور:
   * الحاوية `dir=rtl` تعكس semantics الـ SVG، فيُفرض dir:ltr وحافة النص اليمنى عند (axisLineX - gutter).
   */
  function svgAxisYMoneyTicks(axisLineX, gutterPx, y, formattedMoney) {
    var x = axisLineX - gutterPx;
    return (
      '<text x="' +
      x +
      '" y="' +
      y +
      '" dominant-baseline="middle" text-anchor="end"' +
      ' direction="ltr" style="direction:ltr;unicode-bidi:isolate"' +
      ' font-size="11" font-weight="700" font-family="Tajawal,Segoe UI,sans-serif"' +
      ' letter-spacing=".02em"' +
      ' fill="' +
      CHART_AXIS_FILL +
      '" stroke="' +
      CHART_AXIS_STROKE +
      '" stroke-width="1.4"' +
      ' paint-order="stroke fill">' +
      formattedMoney +
      '</text>'
    );
  }

  /** قيمة فوق العمود — بدون stroke حتى لا تبدو مزدوجة/ضبابية */
  function svgBarValueText(x, y, inner) {
    return (
      '<text x="' +
      x +
      '" y="' +
      y +
      '" text-anchor="middle" dominant-baseline="auto"' +
      ' font-size="11" font-weight="700" font-family="Tajawal,Segoe UI,sans-serif"' +
      ' fill="#fbf4dc">' +
      inner +
      '</text>'
    );
  }

  /** محاور عامة (خط، شرح) */
  function svgChartText(x, y, anchor, fontSize, inner, fill, strokeW) {
    fill = fill || CHART_AXIS_FILL;
    strokeW = strokeW != null ? strokeW : 2.6;
    return (
      '<text x="' +
      x +
      '" y="' +
      y +
      '" text-anchor="' +
      anchor +
      '" font-size="' +
      fontSize +
      '" font-weight="600" font-family="Tajawal,Segoe UI,sans-serif" fill="' +
      fill +
      '" stroke="' +
      CHART_AXIS_STROKE +
      '" stroke-width="' +
      strokeW +
      '" paint-order="stroke fill">' +
      inner +
      '</text>'
    );
  }

  function pUsd(v) {
    if (typeof v === 'number' && isFinite(v)) return v;
    return parseFloat(String(v||'').replace(/[^0-9.]/g,'')) || 0;
  }

  function getPC(b) {
    const d = (b.division||'').toLowerCase(), n = (b.name||'').toLowerCase();
    if (/(سكني|شقق|فلل|فندق|سكن|فيل|فيص)/.test(d)||/(سكني|فيل)/.test(n)) return 'سكن';
    if (/(أرض|زراع)/.test(d)||/أرض/.test(n)) return 'أرض';
    return 'تجاري';
  }

  function getBV(b) {
    if (b.ownedValueUsd) return pUsd(b.ownedValueUsd);
    return typeof b.value==='number' ? b.value/3.75 : 0;
  }

  function getBPaid(b) {
    if (Array.isArray(b.paymentsUsd)&&b.paymentsUsd.length)
      return b.paymentsUsd.reduce((s,p)=>s+(Number(p.amountUsd)||0),0);
    return pUsd(b.totalPaymentsUsd);
  }

  function getBRem(b) {
    if (b.remainingUsd) return pUsd(b.remainingUsd);
    return Math.max(0, getBV(b) - getBPaid(b));
  }

  function getCountry(b) {
    if (typeof inferCountryFromCity==='function') {
      const c = inferCountryFromCity(b.city);
      return c || b.city || 'غير محدد';
    }
    return b.country||b.city||'غير محدد';
  }

  function noData() {
    return '<div style="text-align:center;color:var(--text-muted);padding:28px 0;font-size:12px;font-family:var(--font-body);">لا توجد بيانات كافية</div>';
  }

  function noDataFinance() {
    return (
      '<div role="status" style="text-align:center;color:var(--text-muted);padding:26px 12px;font-size:calc(12px * var(--fs-scale));font-family:var(--font-body);line-height:1.65">' +
      '<strong style="color:var(--text-secondary);display:block;margin-bottom:8px;font-weight:600">لا توجد مبالغ بـ ' +
      escapeCellHtml(FIN_CCY_AR) +
      ' (' +
      escapeCellHtml(FIN_CCY_CODE) +
      ') تُنشئ هذا الرسم بعد</strong>' +
      '<span style="display:block;color:var(--gold-mid);font-size:calc(11px * var(--fs-scale))">تأكد من حقول القيمة والمدفوعات بـ' +
      FIN_CCY_AR +
      ' (' +
      FIN_CCY_CODE +
      ') ضمن كل عقار؛ ولعقارات غير المملوكة أكمل الأسعار في تقرير المالك. المخططات تعرض $ وم (مليون) وك (ألف) باختصار؛ فواصل الآلاف ٬ والكسور ٫ وفق العربية السعودية.</span>' +
      '</div>'
    );
  }

  /* ══════════ SVG RENDERERS ══════════ */

  /* Vertical Bar — opts.currency: صفر إجمالي المبالغ → رسالة أوضاح مالية؛ إطار محاور أوضح للمالية */
  function drawBar(data, opts) {
    opts = opts || {};
    if (!data || !data.length) return opts.currency ? noDataFinance() : noData();
    var sumV = data.reduce(function (s, d) {
      return s + (Number(d.v) || 0);
    }, 0);
    if (!(sumV > 0)) return opts.currency ? noDataFinance() : noData();
    var cur = !!opts.currency;
    var n = data.length;
    var maxV = Math.max.apply(
      null,
      data.map(function (d) {
        return d.v || 0;
      }).concat([0.001])
    );
    var axisX, tickPad, pr, pt, plotH, bottomMargin, reserveTop, W, H, cw, tickLblX;
    var gridStroke, axisStroke, axisW;
    if (cur) {
      axisX = 228;
      tickPad = 28;
      pr = 28;
      pt = 26;
      plotH = 158;
      bottomMargin = 102;
      reserveTop = 50;
      cw = Math.max(292, n * 52);
      W = axisX + cw + pr;
      H = pt + plotH + bottomMargin;
      tickLblX = axisX - tickPad;
      gridStroke = FIN_GRID_STROKE;
      axisStroke = FIN_AXIS_STROKE;
      axisW = '1.45';
    } else {
      axisX = 150;
      tickPad = 16;
      pr = 16;
      pt = 18;
      reserveTop = 0;
      bottomMargin = 62;
      W = Math.max(axisX + 280, axisX + 68 + 260);
      H = 206;
      var ch0 = H - pt - bottomMargin;
      plotH = ch0;
      cw = W - axisX - pr;
      tickLblX = axisX - tickPad;
      gridStroke = 'rgba(148,163,184,.14)';
      axisStroke = 'rgba(148,163,184,.28)';
      axisW = '0.85';
    }
    var bottomY = pt + plotH;
    var plotCh = Math.max(plotH - (cur ? reserveTop : 0), 32);
    var plotPt = pt + (plotH - plotCh);
    var gap = cw / n;
    var bw = Math.max(cur ? 16 : 14, Math.min(cur ? 58 : 52, gap * (cur ? 0.62 : 0.56)));
    var s =
      '<svg viewBox="0 0 ' + W + ' ' + H + '" width="100%" style="display:block;font-family:Tajawal,sans-serif">';
    [0.25, 0.5, 0.75, 1].forEach(function (r) {
      var gy = pt + plotH * (1 - r);
      s +=
        '<line x1="' +
        axisX +
        '" y1="' +
        gy.toFixed(1) +
        '" x2="' +
        (W - pr) +
        '" y2="' +
        gy.toFixed(1) +
        '" stroke="' +
        gridStroke +
        '" stroke-width=".8" stroke-dasharray="5,5"/>';
      if (cur) {
        s +=
          '<line x1="' +
          (axisX - 10) +
          '" y1="' +
          gy.toFixed(1) +
          '" x2="' +
          axisX +
          '" y2="' +
          gy.toFixed(1) +
          '" stroke="' +
          axisStroke +
          '" stroke-width="1.1"/>';
      }
      s += cur
        ? svgAxisYMoneyTicks(axisX, 14, gy, chartAxisFmt(maxV * r, true))
        : svgAxisTickText(tickLblX, gy, svgTickBidi(chartAxisFmt(maxV * r, false), false));
    });
    s +=
      '<line x1="' +
      axisX +
      '" y1="' +
      pt +
      '" x2="' +
      axisX +
      '" y2="' +
      bottomY +
      '" stroke="' +
      axisStroke +
      '" stroke-width="' +
      axisW +
      '"/>';
    s +=
      '<line x1="' +
      axisX +
      '" y1="' +
      bottomY +
      '" x2="' +
      (W - pr) +
      '" y2="' +
      bottomY +
      '" stroke="' +
      axisStroke +
      '" stroke-width="' +
      axisW +
      '"/>';
    var anyLongLabel = false;
    data.forEach(function (d, i) {
      var cx = axisX + gap * i + gap / 2;
      if (cur) {
        s +=
          '<line x1="' +
          cx.toFixed(1) +
          '" y1="' +
          bottomY +
          '" x2="' +
          cx.toFixed(1) +
          '" y2="' +
          (bottomY + 10) +
          '" stroke="' +
          axisStroke +
          '" stroke-width="1.1"/>';
      }
      var bh = plotCh * (d.v / maxV),
        x = cx - bw / 2,
        y = plotPt + plotCh - bh;
      var col = d.c || GC[i % GC.length];
      if (bh > 0)
        s +=
          '<rect x="' +
          x.toFixed(1) +
          '" y="' +
          y.toFixed(1) +
          '" width="' +
          bw +
          '" height="' +
          bh.toFixed(1) +
          '" rx="3" fill="' +
          col +
          '" opacity=".92"/>';
      if (d.v > 0) {
        var valY = y - (cur ? 32 : 26);
        s += svgBarValueText(
          cx.toFixed(1),
          valY,
          svgTickBidi(chartAxisFmt(d.v, cur), cur)
        );
      }
      var lb = d.l || '';
      if (lb.length > 5) anyLongLabel = true;
      var lbase = bottomY + (cur ? 22 : 20);
      if (lb.length > 5) {
        s +=
          '<text x="' +
          cx.toFixed(1) +
          '" y="' +
          lbase +
          '" text-anchor="middle" font-size="' +
          (cur ? '9.5' : '9') +
          '" font-weight="500" fill="var(--text-secondary)" font-family="Tajawal">' +
          lb.slice(0, 5) +
          '</text>';
        s +=
          '<text x="' +
          cx.toFixed(1) +
          '" y="' +
          (lbase + 14) +
          '" text-anchor="middle" font-size="' +
          (cur ? '9.5' : '9') +
          '" font-weight="500" fill="var(--text-secondary)" font-family="Tajawal">' +
          lb.slice(5) +
          '</text>';
      } else {
        s +=
          '<text x="' +
          cx.toFixed(1) +
          '" y="' +
          lbase +
          '" text-anchor="middle" font-size="' +
          (cur ? '10' : '9.5') +
          '" font-weight="500" fill="var(--text-secondary)" font-family="Tajawal">' +
          lb +
          '</text>';
      }
    });
    if (cur) {
      var yMid = (plotPt + bottomY) / 2;
      s +=
        '<text xml:lang="ar" transform="rotate(-90 22 ' +
        yMid.toFixed(1) +
        ')" x="22" y="' +
        yMid.toFixed(1) +
        '" text-anchor="middle" font-size="11" font-weight="600" fill="var(--gold-mid)" font-family="Tajawal,sans-serif">' +
        'محور القيمة ($)' +
        '</text>';
      var xMid = axisX + cw / 2;
      var xCapY = bottomY + (anyLongLabel ? 86 : 70);
      s +=
        '<text xml:lang="ar" x="' +
        xMid.toFixed(1) +
        '" y="' +
        xCapY +
        '" text-anchor="middle" font-size="11" font-weight="600" fill="var(--gold-mid)" font-family="Tajawal,sans-serif">' +
        'محور الفئات' +
        '</text>';
    }
    s += '</svg>';
    return cur ? wrapFinancialChart(s) : s;
  }

  /* Horizontal Bar — تخطيط HTML للعربية (لا تراكب مع شرائح SVG) */
  function drawHBar(data, opts) {
    opts = opts || {};
    if (!data || !data.length) return noData();
    var maxV = Math.max.apply(null, data.map(function (d) { return Number(d.v) || 0; }));
    if (!(maxV > 0)) maxV = 1;
    var rows =
      '<div class="dyn-hbar">' +
      data
        .map(function (d, i) {
          var v = Number(d.v) || 0;
          var pct = Math.min(100, Math.max(v > 0 ? (v / maxV) * 100 : 0, v > 0 ? 3 : 0));
          var col = d.c || GC[i % GC.length];
          var lab = escapeCellHtml(String(d.l != null ? d.l : '').slice(0, 96));
          var num = escapeCellHtml(
            opts.currency ? fK(v) : String(arNums(Math.round(v), { maximumFractionDigits: 0 }))
          );
          var fillStyle = 'width:' + pct.toFixed(2) + '%;background:' + col + ';opacity:.9';
          return (
            '<div class="dyn-hbar-row">' +
              '<div class="dyn-hbar-label" lang="ar" dir="auto">' +
              lab +
              '</div>' +
              '<div class="dyn-hbar-track">' +
              '<span class="dyn-hbar-fill" style="' +
              fillStyle +
              '"></span>' +
              '</div>' +
              '<div class="dyn-hbar-val">' +
              num +
              '</div>' +
              '</div>'
          );
        })
        .join('') +
      '</div>';
    if (opts.currency) {
      var axisHdr =
        '<div class="fin-hbar-axis-row" aria-hidden="true">' +
        '<span class="fin-hbar-y-lab">محور الفئات (الصفوف)</span>' +
        '<span></span>' +
        '<span class="fin-hbar-x-lab">محور القيمة ($)</span>' +
        '</div>';
      return wrapFinancialChart('<div class="fin-hbar-wrap">' + axisHdr + rows + '</div>');
    }
    return rows;
  }

  /* Donut — SVG مقطع فقط؛ الأسطورة HTML لتفادي تداخل العربية RTL مع ماركر اللون في SVG */
  function drawDonut(data, cl, valueKind) {
    var sub = typeof cl !== 'undefined' ? cl : 'نوع';
    var kind = valueKind === 'money' ? 'money' : 'count';
    var finEmpty = kind === 'money';
    if (!data || !data.length) return finEmpty ? noDataFinance() : noData();
    var CX = 82, CY = 82, R = 58, IR = 34, SVG_W = 164, SVG_H = 168;
    var total = 0;
    for (var ti = 0; ti < data.length; ti++) total += Number(data[ti].v) || 0;
    if (total <= 0) return finEmpty ? noDataFinance() : noData();
    var angle = -Math.PI / 2;
    var s = '<div class="donut-wrap donut-wrap--dyn">';
    s += '<svg class="donut-svg" viewBox="0 0 ' + SVG_W + ' ' + SVG_H + '" width="164" height="168" style="max-height:180px;display:block;flex-shrink:0;">';
    data.forEach(function (d, i) {
      var col = d.c || GC[i % GC.length];
      var slice = (d.v / total) * 2 * Math.PI;
      if (slice < 0.01) { angle += slice; return; }
      var x1 = CX + R * Math.cos(angle), y1 = CY + R * Math.sin(angle);
      var x2 = CX + R * Math.cos(angle + slice), y2 = CY + R * Math.sin(angle + slice);
      var ix1 = CX + IR * Math.cos(angle), iy1 = CY + IR * Math.sin(angle);
      var ix2 = CX + IR * Math.cos(angle + slice), iy2 = CY + IR * Math.sin(angle + slice);
      var lg = slice > Math.PI ? 1 : 0;
      s += '<path d="M' + ix1.toFixed(2) + ',' + iy1.toFixed(2) + ' L' + x1.toFixed(2) + ',' + y1.toFixed(2) + ' A' + R + ',' + R + ' 0 ' + lg + ' 1 ' + x2.toFixed(2) + ',' + y2.toFixed(2) + ' L' + ix2.toFixed(2) + ',' + iy2.toFixed(2) + ' A' + IR + ',' + IR + ' 0 ' + lg + ' 0 ' + ix1.toFixed(2) + ',' + iy1.toFixed(2) + ' Z" fill="' + col + '" stroke="var(--bg-card)" stroke-width="1.5"/>';
      angle += slice;
    });
    s += '<circle cx="' + CX + '" cy="' + CY + '" r="' + IR + '" fill="var(--bg-card)"/>';
    var centerStr = kind === 'money' ? fK(total) : Math.round(total).toLocaleString('ar-SA');
    s += '<text x="' + CX + '" y="' + (CY - 4) + '" text-anchor="middle" font-family="Amiri" font-size="17" fill="var(--gold-bright)" font-weight="700">' + centerStr + '</text>';
    s += '<text x="' + CX + '" y="' + (CY + 13) + '" text-anchor="middle" font-family="Tajawal" font-size="8.5" fill="var(--text-muted)">' + escapeCellHtml(String(sub)) + '</text>';
    s += '</svg><div class="donut-legend">';
    data.forEach(function (d, i) {
      var pct = Math.round((d.v / total) * 100);
      var col = d.c || GC[i % GC.length];
      var lab = escapeCellHtml(String(d.l || '').slice(0, 80));
      s += '<div class="legend-item"><div class="legend-dot" style="background:' + col + '"></div><span class="legend-label">' + lab + '</span><span class="legend-pct">' + pct.toLocaleString('ar-SA') + '%</span></div>';
    });
    s += '</div></div>';
    return kind === 'money' ? wrapFinancialChart(s) : s;
  }

  /* Stacked Bar — مالي فقط؛ نفس إطار المحاور السفلي/الأيسر */
  function drawStacked(data) {
    if (!data || !data.length) return noDataFinance();
    var stackSum = data.reduce(function (s, row) {
      return s + (row.segs || []).reduce(function (a, seg) {
        return a + (Number(seg.v) || 0);
      }, 0);
    }, 0);
    if (!(stackSum > 0)) return noDataFinance();
    var n = data.length;
    var axisX = 228,
      pr = 28,
      pt = 26,
      plotH = 158,
      bottomMargin = 102,
      H = pt + plotH + bottomMargin,
      cw = Math.max(292, n * 52),
      W = axisX + cw + pr;
    var maxV = Math.max.apply(
      null,
      data.map(function (d) {
        return d.segs.reduce(function (s, g) {
          return s + (g.v || 0);
        }, 0);
      }).concat([0.001])
    );
    var gap = cw / n;
    var bw = Math.max(18, Math.min(56, gap * 0.62));
    var bottomY = pt + plotH;
    var s =
      '<svg viewBox="0 0 ' + W + ' ' + H + '" width="100%" style="display:block;font-family:Tajawal,sans-serif">';
    [0.25, 0.5, 0.75, 1].forEach(function (r) {
      var gy = pt + plotH * (1 - r);
      s +=
        '<line x1="' +
        axisX +
        '" y1="' +
        gy.toFixed(1) +
        '" x2="' +
        (W - pr) +
        '" y2="' +
        gy.toFixed(1) +
        '" stroke="' +
        FIN_GRID_STROKE +
        '" stroke-width=".8" stroke-dasharray="5,5"/>';
      s +=
        '<line x1="' +
        (axisX - 10) +
        '" y1="' +
        gy.toFixed(1) +
        '" x2="' +
        axisX +
        '" y2="' +
        gy.toFixed(1) +
        '" stroke="' +
        FIN_AXIS_STROKE +
        '" stroke-width="1.1"/>';
      s += svgAxisYMoneyTicks(axisX, 14, gy, chartAxisFmt(maxV * r, true));
    });
    s +=
      '<line x1="' +
      axisX +
      '" y1="' +
      pt +
      '" x2="' +
      axisX +
      '" y2="' +
      bottomY +
      '" stroke="' +
      FIN_AXIS_STROKE +
      '" stroke-width="1.45"/>';
    s +=
      '<line x1="' +
      axisX +
      '" y1="' +
      bottomY +
      '" x2="' +
      (W - pr) +
      '" y2="' +
      bottomY +
      '" stroke="' +
      FIN_AXIS_STROKE +
      '" stroke-width="1.45"/>';
    var anyLong = false;
    data.forEach(function (d, i) {
      var cx = axisX + gap * i + gap / 2,
        x = cx - bw / 2;
      if ((d.l || '').length > 5) anyLong = true;
      s +=
        '<line x1="' +
        cx.toFixed(1) +
        '" y1="' +
        bottomY +
        '" x2="' +
        cx.toFixed(1) +
        '" y2="' +
        (bottomY + 10) +
        '" stroke="' +
        FIN_AXIS_STROKE +
        '" stroke-width="1.1"/>';
      var sy = bottomY;
      d.segs.forEach(function (seg) {
        if (!seg.v || seg.v <= 0) return;
        var bh = plotH * (seg.v / maxV);
        sy -= bh;
        s +=
          '<rect x="' +
          x.toFixed(1) +
          '" y="' +
          sy.toFixed(1) +
          '" width="' +
          bw +
          '" height="' +
          bh.toFixed(1) +
          '" rx="2" fill="' +
          seg.c +
          '" opacity=".92"/>';
      });
      var lb = d.l || '';
      var lbase = bottomY + 22;
      if (lb.length > 5) {
        s +=
          '<text x="' +
          cx.toFixed(1) +
          '" y="' +
          lbase +
          '" text-anchor="middle" font-size="9.5" font-weight="500" fill="var(--text-secondary)" font-family="Tajawal">' +
          lb.slice(0, 5) +
          '</text>';
        s +=
          '<text x="' +
          cx.toFixed(1) +
          '" y="' +
          (lbase + 14) +
          '" text-anchor="middle" font-size="9.5" font-weight="500" fill="var(--text-secondary)" font-family="Tajawal">' +
          lb.slice(5) +
          '</text>';
      } else {
        s +=
          '<text x="' +
          cx.toFixed(1) +
          '" y="' +
          lbase +
          '" text-anchor="middle" font-size="10" font-weight="500" fill="var(--text-secondary)" font-family="Tajawal">' +
          lb +
          '</text>';
      }
    });
    var yMid = (pt + bottomY) / 2;
    s +=
      '<text xml:lang="ar" transform="rotate(-90 22 ' +
      yMid.toFixed(1) +
      ')" x="22" y="' +
      yMid.toFixed(1) +
      '" text-anchor="middle" font-size="11" font-weight="600" fill="var(--gold-mid)" font-family="Tajawal,sans-serif">' +
      'محور القيمة ($)' +
      '</text>';
    var xCapY = bottomY + (anyLong ? 86 : 70);
    s +=
      '<text xml:lang="ar" x="' +
      (axisX + cw / 2).toFixed(1) +
      '" y="' +
      xCapY +
      '" text-anchor="middle" font-size="11" font-weight="600" fill="var(--gold-mid)" font-family="Tajawal,sans-serif">' +
      'محور الفئات' +
      '</text>';
    s += '</svg>';
    return wrapFinancialChart(s);
  }

  /* Line Chart */
  function drawLine(series, labels, opts) {
    opts = opts || {};
    if (!series || !labels || !labels.length) return opts.currency ? noDataFinance() : noData();
    var allSum = series.reduce(function (s, ser) {
      return (
        s +
        (Array.isArray(ser.vals)
          ? ser.vals.reduce(function (a, v) {
              return a + (Number(v) || 0);
            }, 0)
          : 0)
      );
    }, 0);
    if (!(allSum > 0)) return opts.currency ? noDataFinance() : noData();
    var cur = !!opts.currency;
    var n = labels.length;
    var allV = series.flatMap(function (s) {
      return s.vals;
    });
    var maxV = Math.max.apply(null, allV.concat([0.001]));
    var axisX, tickPad, pr, pt, plotH, bottomMargin, W, H, cw, tickLblX;
    var gridStroke, axisStroke, axisW, labFs, labY;
    var rotBump = n > 10 ? 28 : 0;
    var legRenderable = series.filter(function (z) {
      return Array.isArray(z.vals) && z.vals.length >= 2;
    });
    var legN = legRenderable.length;
    var legBump = legN > 1 ? (cur ? 22 + legN * 26 : 34) : 0;
    if (cur) {
      axisX = 228;
      tickPad = 28;
      pr = 28;
      pt = 28;
      plotH = 152;
      bottomMargin = 118 + legBump + rotBump + (legN > 1 ? 12 : 0);
      cw = Math.max(300, (n - 1) * 44 + 1);
      tickLblX = axisX - tickPad;
      gridStroke = FIN_GRID_STROKE;
      axisStroke = FIN_AXIS_STROKE;
      axisW = '1.45';
      labFs = n > 9 ? '8.2' : '9.5';
      W = axisX + cw + pr;
    } else {
      axisX = 150;
      tickPad = 16;
      pr = 18;
      pt = 18;
      bottomMargin = 52;
      W = Math.max(axisX + 285, axisX + 68 + 268);
      H = 202;
      plotH = H - pt - bottomMargin;
      cw = W - axisX - pr;
      tickLblX = axisX - tickPad;
      gridStroke = 'rgba(148,163,184,.12)';
      axisStroke = 'rgba(148,163,184,.28)';
      axisW = '0.85';
      labFs = '9';
    }
    if (cur) {
      H = pt + plotH + bottomMargin;
    }
    var bottomY = pt + plotH;
    if (cur) {
      labY = bottomY + (n > 9 ? 16 : 20);
    } else {
      labY = bottomY + 18;
    }
    var xStep = n > 1 ? cw / (n - 1) : cw;
    var s =
      '<svg viewBox="0 0 ' + W + ' ' + H + '" width="100%" style="display:block;font-family:Tajawal,sans-serif">';
    [0.25, 0.5, 0.75, 1].forEach(function (r) {
      var gy = pt + plotH * (1 - r);
      s +=
        '<line x1="' +
        axisX +
        '" y1="' +
        gy.toFixed(1) +
        '" x2="' +
        (W - pr) +
        '" y2="' +
        gy.toFixed(1) +
        '" stroke="' +
        gridStroke +
        '" stroke-width=".75" stroke-dasharray="5,5"/>';
      if (cur) {
        s +=
          '<line x1="' +
          (axisX - 10) +
          '" y1="' +
          gy.toFixed(1) +
          '" x2="' +
          axisX +
          '" y2="' +
          gy.toFixed(1) +
          '" stroke="' +
          axisStroke +
          '" stroke-width="1.1"/>';
      }
      s += cur
        ? svgAxisYMoneyTicks(axisX, 14, gy, chartAxisFmt(maxV * r, true))
        : svgAxisTickText(tickLblX, gy, svgTickBidi(chartAxisFmt(maxV * r, false), false));
    });
    s +=
      '<line x1="' +
      axisX +
      '" y1="' +
      pt +
      '" x2="' +
      axisX +
      '" y2="' +
      bottomY +
      '" stroke="' +
      axisStroke +
      '" stroke-width="' +
      axisW +
      '"/>';
    s +=
      '<line x1="' +
      axisX +
      '" y1="' +
      bottomY +
      '" x2="' +
      (W - pr) +
      '" y2="' +
      bottomY +
      '" stroke="' +
      axisStroke +
      '" stroke-width="' +
      axisW +
      '"/>';
    labels.forEach(function (lab, i) {
      var xi = axisX + i * xStep;
      if (cur) {
        s +=
          '<line x1="' +
          xi.toFixed(1) +
          '" y1="' +
          bottomY +
          '" x2="' +
          xi.toFixed(1) +
          '" y2="' +
          (bottomY + 9) +
          '" stroke="' +
          axisStroke +
          '" stroke-width="1.1"/>';
      }
      var rot = n > 10 ? ' transform="rotate(-32 ' + xi.toFixed(1) + ' ' + labY + ')"' : '';
      s +=
        '<text xml:lang="ar" x="' +
        xi.toFixed(1) +
        '" y="' +
        labY +
        '"' +
        rot +
        ' text-anchor="middle" font-size="' +
        labFs +
        '" font-weight="500" fill="var(--text-secondary)" font-family="Tajawal">' +
        lab +
        '</text>';
    });
    series.forEach(function (ser, si) {
      var col = ser.c || GC[si % GC.length];
      if (ser.vals.length < 2) return;
      var pts = ser.vals
        .map(function (v, i) {
          var x = axisX + i * xStep,
            y = bottomY - plotH * (v / maxV);
          return x.toFixed(1) + ',' + y.toFixed(1);
        })
        .join(' ');
      var first = axisX + ',' + bottomY,
        last = (axisX + (n - 1) * xStep).toFixed(1) + ',' + bottomY;
      s += '<polygon points="' + first + ' ' + pts + ' ' + last + '" fill="' + col + '" opacity=".07"/>';
      s +=
        '<polyline points="' +
        pts +
        '" fill="none" stroke="' +
        col +
        '" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>';
      ser.vals.forEach(function (v, i) {
        var x = axisX + i * xStep,
          y = bottomY - plotH * (v / maxV);
        s +=
          '<circle cx="' +
          x.toFixed(1) +
          '" cy="' +
          y.toFixed(1) +
          '" r="3" fill="var(--bg-card)" stroke="' +
          col +
          '" stroke-width="1.8"/>';
      });
    });
    var legBase = cur ? (n > 10 ? bottomY + 52 : bottomY + 44) : bottomY + 33;
    var legGap = 0;
    var legFirstY = 0;
    if (legN > 1 && cur) {
      legGap = n > 10 ? 12 : 10;
      legFirstY = legBase + legGap;
      var legendBlockW = Math.min(280, Math.max(160, cw - 24));
      var legOriginX = axisX + Math.max(10, (cw - legendBlockW) / 2);
      legRenderable.forEach(function (ser, si) {
        var col = ser.c || GC[si % GC.length];
        var rowY = legFirstY + si * 26;
        var sw0 = legOriginX + 4;
        var sw1 = sw0 + 26;
        var tx = sw1 + 12;
        s +=
          '<line x1="' +
          sw0 +
          '" y1="' +
          rowY +
          '" x2="' +
          sw1 +
          '" y2="' +
          rowY +
          '" stroke="' +
          col +
          '" stroke-width="3" stroke-linecap="round"/>';
        s +=
          '<text xml:lang="ar" x="' +
          tx +
          '" y="' +
          rowY +
          '" dominant-baseline="middle" text-anchor="start"' +
          ' direction="rtl"' +
          ' style="direction:rtl;unicode-bidi:plaintext"' +
          ' font-size="10.5" font-weight="600" fill="var(--text-secondary)" font-family="Tajawal,sans-serif">' +
          escapeCellHtml(String(ser.name != null ? ser.name : '').slice(0, 48)) +
          '</text>';
      });
    } else if (legN > 1 && !cur) {
      var lx = axisX;
      legRenderable.forEach(function (ser, si) {
        var col = ser.c || GC[si % GC.length];
        s +=
          '<line x1="' +
          lx +
          '" y1="' +
          (legBase - 4) +
          '" x2="' +
          (lx + 16) +
          '" y2="' +
          (legBase - 4) +
          '" stroke="' +
          col +
          '" stroke-width="2" stroke-linecap="round"/>';
        s +=
          '<text x="' +
          (lx + 20) +
          '" y="' +
          legBase +
          '" font-size="9" fill="var(--text-secondary)" font-family="Tajawal">' +
          (ser.name || '') +
          '</text>';
        lx += Math.max(118, Math.floor(cw / Math.max(legN, 2)));
      });
    }
    if (cur) {
      var yTitleX = 34;
      var yMid = (pt + bottomY) / 2;
      s +=
        '<text xml:lang="ar" transform="rotate(-90 ' +
        yTitleX +
        ' ' +
        yMid.toFixed(1) +
        ')" x="' +
        yTitleX +
        '" y="' +
        yMid.toFixed(1) +
        '" text-anchor="middle" font-size="11" font-weight="600" fill="var(--gold-mid)" font-family="Tajawal,sans-serif">' +
        'محور القيمة ($)' +
        '</text>';
      var capAfterLeg =
        legN > 1 ? legFirstY + legN * 26 + 16 : n > 10 ? bottomY + 82 : bottomY + 72;
      var capY =
        legN > 1 ? capAfterLeg : (n > 10 ? bottomY + 82 : bottomY + 72);
      s +=
        '<text xml:lang="ar" x="' +
        (axisX + cw / 2).toFixed(1) +
        '" y="' +
        capY +
        '" text-anchor="middle" font-size="11" font-weight="600" fill="var(--gold-mid)" font-family="Tajawal,sans-serif">' +
        'محور الفترات / التصنيف' +
        '</text>';
    }
    s += '</svg>';
    return cur ? wrapFinancialChart(s) : s;
  }

  /* ══════════ Chart Switch System ══════════ */
  const DYNREG = {};

  window.switchDynChart = function(id, type) {
    document.querySelectorAll('[data-chart-wrap="'+id+'"] .ctt-btn').forEach(function(b){
      b.classList.toggle('active', b.dataset.ctype===type);
    });
    const c = DYNREG[id];
    if (!c) return;
    const el = document.getElementById(id);
    if (el) el.innerHTML = c(type);
  };

  function reg(id, fn) {
    DYNREG[id] = fn;
    var el = document.getElementById(id);
    if (!el) return;
    var wrap = document.querySelector('[data-chart-wrap="' + id + '"]');
    var activeBtn = wrap && wrap.querySelector('.ctt-btn.active');
    var initType =
      activeBtn && activeBtn.getAttribute('data-ctype')
        ? activeBtn.getAttribute('data-ctype')
        : 'bar';
    el.innerHTML = fn(initType);
  }

  /* ── Data helpers ── */
  function richnessOwnerRows(rows) {
    if (!Array.isArray(rows)) return 0;
    return rows.reduce(function (sum, o) {
      const a = Array.isArray(o && o.ownerProperties) ? o.ownerProperties.length : 0;
      const b = Array.isArray(o && o.propertyIds) ? o.propertyIds.length : 0;
      return sum + Math.max(a, b);
    }, 0);
  }

  /** يمزج مصادر تقرير المالك لتفادي بيانات ناقصة عند وجودنسخ أكمل في الذاكرة أو العكس */
  function getOwners() {
    var fromAux = [];
    try { fromAux = (AUX_RECORDS_CONFIG.owners && AUX_RECORDS_CONFIG.owners.data) || []; } catch (e) {}
    var fromLs = [];
    try { fromLs = JSON.parse(localStorage.getItem('ownersData') || '[]'); } catch (e) {}
    if (!Array.isArray(fromAux)) fromAux = [];
    if (!Array.isArray(fromLs)) fromLs = [];
    if (richnessOwnerRows(fromLs) > richnessOwnerRows(fromAux)) return fromLs;
    if (fromAux.length > 0) return fromAux;
    return fromLs;
  }

  function siteLabelFromOwnerLocation(loc) {
    var s = String(loc || '').trim();
    if (!s) return 'غير محدد';
    var parts = s.split(/\s*[-–،,]\s*/).map(function (x) { return x.trim(); }).filter(Boolean);
    return parts[0] || 'غير محدد';
  }

  function getConsultations() {
    try { return AUX_RECORDS_CONFIG.consultations.data||[]; } catch(e){ return []; }
  }

  function getAttachmentsRows() {
    try { return (AUX_RECORDS_CONFIG.attachments && AUX_RECORDS_CONFIG.attachments.data) || []; } catch (e) {
      return [];
    }
  }

  /** تقارير الاستشارات المرتبطة بعقار (بحسب للإشارة)؛ لا تعيد احتساب صف موجود أصلاً في إشارات العقار بالمعرف/رقم العقد */
  function consultExtraCountForBuilding(b, consultations) {
    var nm = ((b && b.name) || '').trim();
    var propNo = ((b && b.propNo) || '').trim().replace(/\s+/g, ' ');
    if (!nm && !propNo) return 0;
    var known = {};
    (Array.isArray(b.signals) ? b.signals : []).forEach(function (s) {
      ['signalId', 'no'].forEach(function (k) {
        var key = String((s && s[k]) || '').trim();
        if (key) known[key.toLowerCase()] = 1;
      });
    });
    function rowMatches(fsRaw) {
      var fs = String(fsRaw || '').trim();
      if (!fs) return false;
      var fsN = fs.replace(/\s+/g, ' ');
      if (nm) {
        if (nm.indexOf(fsN) !== -1 || fsN.indexOf(nm) !== -1) return true;
        var head = fsN.length > 14 ? fsN.slice(0, 14) : fsN;
        if (head.length >= 4 && nm.indexOf(head) !== -1) return true;
      }
      if (propNo && (fsN.indexOf(propNo) !== -1 || propNo.indexOf(fsN) !== -1)) return true;
      return false;
    }
    var extras = 0;
    var list = Array.isArray(consultations) ? consultations : [];
    for (var ci = 0; ci < list.length; ci++) {
      var c = list[ci];
      var linkedPid = !!(b.propId && Array.isArray(c.propertyIds) && c.propertyIds.indexOf(b.propId) !== -1);
      if (!linkedPid && !rowMatches((c && c.forSignal) || '')) continue;
      var cid = [
        String((c && c.signalId) || '').trim().toLowerCase(),
        String((c && c.signalContractNo) || '').trim().toLowerCase(),
      ].filter(Boolean);
      if (cid.some(function (k) { return known[k]; })) continue;
      cid.forEach(function (k) { known[k] = 1; });
      extras++;
    }
    return extras;
  }

  /* ══════════ FINANCIAL CHARTS ══════════ */

  function initFinCharts() {
    var cats = ['سكن','تجاري','أرض'];

    /* FIN-1: قيمة العقارات المملوكة حسب النوع */
    reg('fin1', function(type) {
      var byT={};
      cats.forEach(function(c){byT[c]=0;});
      buildings.forEach(function(b){
        var cat=getPC(b); byT[cat]=(byT[cat]||0)+getBV(b);
      });
      var data=cats.map(function(c){return{l:c,v:byT[c]||0,c:CC[c]};});
      return type==='donut'?drawDonut(data,'نوع','money'):drawBar(data,{currency:true});
    });

    /* FIN-2: الدفعات الكاملة */
    reg('fin2', function(type) {
      var byT={};
      cats.forEach(function(c){byT[c]=0;});
      buildings.forEach(function(b){
        if(getBRem(b)<=0&&getBV(b)>0){var cat=getPC(b);byT[cat]=(byT[cat]||0)+getBV(b);}
      });
      var data=cats.map(function(c){return{l:c,v:byT[c]||0,c:CC[c]};});
      return type==='donut'?drawDonut(data,'نوع','money'):drawBar(data,{currency:true});
    });

    /* FIN-3: الدفعات الجزئية */
    reg('fin3', function(type) {
      var byT={};
      cats.forEach(function(c){byT[c]=0;});
      buildings.forEach(function(b){
        var paid=getBPaid(b),rem=getBRem(b);
        if(rem>0&&paid>0){var cat=getPC(b);byT[cat]=(byT[cat]||0)+paid;}
      });
      var data=cats.map(function(c){return{l:c,v:byT[c]||0,c:CC[c]};});
      return type==='donut'?drawDonut(data,'نوع','money'):drawBar(data,{currency:true});
    });

    /* FIN-4: إجمالي المبلغ المدفوع */
    reg('fin4', function(type) {
      var byT={},total=0;
      cats.forEach(function(c){byT[c]=0;});
      buildings.forEach(function(b){
        var paid=getBPaid(b),cat=getPC(b);
        byT[cat]=(byT[cat]||0)+paid; total+=paid;
      });
      var el=document.getElementById('fin4-total');
      if (el) el.textContent = fK(total);
      var data=cats.map(function(c){return{l:c,v:byT[c]||0,c:CC[c]};});
      return type==='donut'?drawDonut(data,'نوع','money'):drawBar(data,{currency:true});
    });

    /* FIN-5: إجمالي قيمة غير المملوكة */
    reg('fin5', function(type) {
      var own=getOwners(),aprx=0,actl=0;
      own.forEach(function(o){aprx+=o.approxPrice||0;actl+=o.actualPrice||0;});
      if (!(aprx+actl > 0)) return noDataFinance();
      var data=[{l:'تقريبي',v:aprx,c:'#C49A2A'},{l:'فعلي',v:actl,c:'#D4AF37'}];
      return type==='donut'?drawDonut(data,'نوع','money'):drawBar(data,{currency:true});
    });

    /* FIN-6: الدفعات والمتبقي لغير المملوكة حسب النوع */
    reg('fin6', function(type) {
      var own=getOwners(),byT={};
      own.forEach(function(o){
        (o.ownerProperties||[]).forEach(function(p){
          var cat=p.propertyCategory||'أخرى';
          if(!byT[cat]) byT[cat]={a:0,b:0};
          byT[cat].a+=p.actualPrice||0;
          byT[cat].b+=p.approxPrice||0;
        });
      });
      var keys=Object.keys(byT);
      if (!keys.length) return noDataFinance();
      if(type==='stacked'){
        var sd=keys.map(function(k){return{l:k,segs:[{v:byT[k].a,c:'#D4AF37'},{v:Math.max(0,byT[k].b-byT[k].a),c:'rgba(139,105,20,.55)'}]};});
        return drawStacked(sd);
      }
      var data=keys.map(function(k,i){return{l:k,v:byT[k].a,c:GC[i%GC.length]};});
      return type==='donut'?drawDonut(data,'نوع','money'):drawBar(data,{currency:true});
    });

    /* FIN-7: قيمة فعلية لغير المملوكة حسب النوع */
    reg('fin7', function(type) {
      var own=getOwners(),byT={};
      own.forEach(function(o){
        (o.ownerProperties||[]).forEach(function(p){
          var cat=p.propertyCategory||'أخرى';
          byT[cat]=(byT[cat]||0)+(p.actualPrice||0);
        });
      });
      if (!Object.keys(byT).length) return noDataFinance();
      var data=Object.keys(byT).map(function(k,i){return{l:k,v:byT[k],c:CC[k]||GC[i%GC.length]};});
      return type==='donut'?drawDonut(data,'نوع','money'):drawBar(data,{currency:true});
    });

    /* FIN-8: قيمة تقريبية لغير المملوكة حسب النوع */
    reg('fin8', function(type) {
      var own=getOwners(),byT={};
      own.forEach(function(o){
        (o.ownerProperties||[]).forEach(function(p){
          var cat=p.propertyCategory||'أخرى';
          byT[cat]=(byT[cat]||0)+(p.approxPrice||0);
        });
      });
      if (!Object.keys(byT).length) return noDataFinance();
      var data=Object.keys(byT).map(function(k,i){return{l:k,v:byT[k],c:CC[k]||GC[i%GC.length]};});
      return type==='donut'?drawDonut(data,'نوع','money'):drawBar(data,{currency:true});
    });

    /* FIN-9: أعلى العقارات من حيث المبلغ المتبقي */
    reg('fin9', function(type) {
      var top=[...buildings].map(function(b){return{l:(b.name||'').slice(0,14),v:getBRem(b)};})
        .filter(function(d){return d.v>0;}).sort(function(a,b){return b.v-a.v;}).slice(0,7)
        .map(function(d,i){return Object.assign({},d,{c:GC[i%GC.length]});});
      if(!top.length) return '<div style="text-align:center;color:var(--text-muted);padding:24px;font-size:12px;">جميع العقارات مسددة بالكامل</div>';
      if(type==='donut') return drawDonut(top,'عقار','money');
      if(type==='bar') return drawBar(top,{currency:true});
      return drawHBar(top, { currency: true });
    });

    /* FIN-10: أعلى المناطق الجغرافية تكلفة */
    reg('fin10', function(type) {
      var byC={};
      buildings.forEach(function(b){var c=b.city||'غير محدد';byC[c]=(byC[c]||0)+getBV(b);});
      var top=Object.entries(byC).sort(function(a,b){return b[1]-a[1];}).slice(0,7)
        .map(function(e,i){return{l:e[0],v:e[1],c:GC[i%GC.length]};});
      if(type==='donut') return drawDonut(top,'مدينة','money');
      if(type==='bar') return drawBar(top,{currency:true});
      return drawHBar(top, { currency: true });
    });

    /* FIN-11: تطور المحفظة سنوياً */
    reg('fin11', function(type) {
      var byY={};
      buildings.forEach(function(b){
        var yr=b.ownDate?parseInt(b.ownDate.split('-')[0]):(b.year||null);
        if(!yr) return;
        if(!byY[yr]) byY[yr]={cnt:0,val:0,paid:0};
        byY[yr].cnt++; byY[yr].val+=getBV(b); byY[yr].paid+=getBPaid(b);
      });
      var years=Object.keys(byY).sort();
      if(!years.length) return noData();
      if(type==='bar')
        return drawBar(
          years.map(function(y,i){return{l:y,v:byY[y].val,c:GC[i%GC.length]};}),
          { currency: true }
        );
      return drawLine(
        [{name:'القيمة',vals:years.map(function(y){return byY[y].val;}),c:'#D4AF37'},
         {name:'المدفوع',vals:years.map(function(y){return byY[y].paid;}),c:'#8B6914'}],
        years,
        { currency: true }
      );
    });
  }

  /* ══════════ ADMINISTRATIVE CHARTS ══════════ */

  function initAdmCharts() {
    var own = getOwners(),
      cons = getConsultations(),
      attRows = getAttachmentsRows();

    /* ADM-1: المملوكة حسب النوع/الموقع */
    reg('adm1', function(type) {
      if(type==='country'){
        var byC={};
        buildings.forEach(function(b){var c=getCountry(b)||'غير محدد';byC[c]=(byC[c]||0)+1;});
        var data=Object.entries(byC).sort(function(a,b){return b[1]-a[1];}).map(function(e,i){return{l:e[0],v:e[1],c:GC[i%GC.length]};});
        return drawDonut(data,'دولة');
      }
      var byT={'سكن':0,'تجاري':0,'أرض':0};
      buildings.forEach(function(b){var cat=getPC(b);byT[cat]=(byT[cat]||0)+1;});
      var data=Object.entries(byT).map(function(e,i){return{l:e[0],v:e[1],c:GC[i%GC.length]};});
      return type==='donut'?drawDonut(data,'نوع'):drawBar(data);
    });

    /* ADM-2: غير المملوكة حسب النوع/الموقع */
    reg('adm2', function(type) {
      var props=[];
      own.forEach(function(o){(o.ownerProperties||[]).forEach(function(p){props.push(p);});});
      if(type==='country'){
        var byC={};
        props.forEach(function(p){var loc=siteLabelFromOwnerLocation(p.location);byC[loc]=(byC[loc]||0)+1;});
        if(!Object.keys(byC).length) return noData();
        var data=Object.entries(byC).sort(function(a,b){return b[1]-a[1];}).map(function(e,i){return{l:e[0],v:e[1],c:GC[i%GC.length]};});
        return drawDonut(data,'موقع');
      }
      var byT={};
      props.forEach(function(p){var cat=p.propertyCategory||'أخرى';byT[cat]=(byT[cat]||0)+1;});
      if(!Object.keys(byT).length) return noData();
      var data=Object.entries(byT).map(function(e,i){return{l:e[0],v:e[1],c:GC[i%GC.length]};});
      return type==='donut'?drawDonut(data,'نوع'):drawBar(data);
    });

    /* ADM-3: كل عقار — إشارات العقار + استشارات مرتبطة من تقرير الإشارات */
    reg('adm3', function(type) {
      var data = buildings
        .map(function (b, i) {
          var nSig = Array.isArray(b.signals) ? b.signals.length : 0;
          var nCons = consultExtraCountForBuilding(b, cons);
          var label = ((b.name && b.name.trim()) || (b.propNo && b.propNo.trim()) || '—').slice(0, 80);
          return { l: label, v: nSig + nCons, c: GC[i % GC.length] };
        })
        .sort(function (a, b) {
          return b.v - a.v;
        })
        .slice(0, 10);
      if (type === 'donut') return drawDonut(data.filter(function (d) { return d.v > 0; }), 'عقار');
      if (type === 'bar') return drawBar(data);
      return drawHBar(data);
    });

    /* ADM-4: المدخلون — عدد السجلات المدخلة من تقارير العقارات والمالك والاستشارات والملحقات */
    reg('adm4', function (type) {
      var tally = {};
      function add(nm) {
        if (!nm || !String(nm).trim()) return;
        var k = String(nm).trim();
        tally[k] = (tally[k] || 0) + 1;
      }
      buildings.forEach(function (b) {
        add(b.enteredBy);
      });
      own.forEach(function (o) {
        add(o.enteredBy);
      });
      cons.forEach(function (c) {
        add(c.enteredBy);
      });
      attRows.forEach(function (a) {
        add(a.enteredBy);
      });
      var list = Object.keys(tally);
      var el = document.getElementById('adm4-count');
      if (el) el.textContent = list.length ? list.length.toLocaleString('ar-SA') : '—';
      if (!list.length) {
        if (el) el.textContent = '—';
        return noData();
      }
      var data = Object.entries(tally)
        .sort(function (a, b) {
          return b[1] - a[1];
        })
        .map(function (e, i) {
          return { l: e[0], v: e[1], c: GC[i % GC.length] };
        });
      return type === 'donut' ? drawDonut(data, 'مدخل') : type === 'hbar' ? drawHBar(data) : drawBar(data);
    });

    /* ADM-5: عدد المالكين */
    reg('adm5', function(type) {
      var total=own.length;
      var el=document.getElementById('adm5-count');
      if(el) el.textContent=total||'—';
      if(!total) return noData();
      var byT={};
      own.forEach(function(o){var t=o.ownerType||'رئيسي';byT[t]=(byT[t]||0)+1;});
      var data=Object.entries(byT).map(function(e,i){return{l:e[0],v:e[1],c:GC[i%GC.length]};});
      if(!data.length) data=[{l:'مالكون',v:total,c:'#D4AF37'}];
      return type==='bar'?drawBar(data):drawDonut(data,'مالك');
    });

    /* ADM-6: عدد الإشارات حسب النوع */
    reg('adm6', function(type) {
      var byT={},total=0;
      buildings.forEach(function(b){(b.signals||[]).forEach(function(sig){total++;var t=sig.type||'أخرى';byT[t]=(byT[t]||0)+1;});});
      cons.forEach(function(c){total++;var t=c.signalType||'أخرى';byT[t]=(byT[t]||0)+1;});
      var el=document.getElementById('adm6-count');
      if(el) el.textContent=total||'—';
      var data=Object.entries(byT).sort(function(a,b){return b[1]-a[1];}).map(function(e,i){return{l:e[0],v:e[1],c:GC[i%GC.length]};});
      return data.length?(type==='donut'?drawDonut(data,'نوع'):drawBar(data)):noData();
    });

    /* ADM-7: عدد الدعاوي */
    reg('adm7', function(type) {
      var byP={},count=0;
      buildings.forEach(function(b){(b.signals||[]).forEach(function(sig){if(sig.type==='دعوى'){count++;var n=(b.name||'').slice(0,12);byP[n]=(byP[n]||0)+1;}});});
      cons.forEach(function(c){if(c.signalType==='دعوى'){count++;var lbl='غير محدد';if(Array.isArray(c.propertyIds)&&c.propertyIds.length){var px=buildings.find(function(x){return x.propId===c.propertyIds[0];});lbl=(px&&px.name)||String(c.propertyIds[0]);}var n=String(lbl||'غير محدد').slice(0,12);byP[n]=(byP[n]||0)+1;}});
      var el=document.getElementById('adm7-count');
      if(el) el.textContent=count||'—';
      var data=Object.entries(byP).sort(function(a,b){return b[1]-a[1];}).map(function(e,i){return{l:e[0],v:e[1],c:GC[i%GC.length]};});
      return data.length?(type==='donut'?drawDonut(data,'عقار'):drawHBar(data)):noData();
    });

    /* ADM-8: أكثر شخص لديه إشارات */
    reg('adm8', function(type) {
      var byP={};
      buildings.forEach(function(b){(b.signals||[]).forEach(function(sig){(sig.owners||[]).forEach(function(o){byP[o]=(byP[o]||0)+1;});});});
      cons.forEach(function(c){(c.claimantOwnerIds||[]).forEach(function(oid){var name=(getAuxOwnerRowMap()[oid]||{}).ownerName||oid;if(name)byP[name]=(byP[name]||0)+1;});});
      var data=Object.entries(byP).sort(function(a,b){return b[1]-a[1];}).slice(0,7).map(function(e,i){return{l:e[0].slice(0,14),v:e[1],c:GC[i%GC.length]};});
      return data.length?(type==='donut'?drawDonut(data,'شخص'):drawHBar(data)):noData();
    });

    /* ADM-9: أكثر شخص مدعى عليه */
    reg('adm9', function(type) {
      var byP={};
      buildings.forEach(function(b){(b.signals||[]).forEach(function(sig){(sig.defendants||[]).forEach(function(d){byP[d]=(byP[d]||0)+1;});});});
      cons.forEach(function(c){(c.defendantOwnerIds||[]).forEach(function(oid){var name=(getAuxOwnerRowMap()[oid]||{}).ownerName||oid;if(name&&name!=='—')byP[name]=(byP[name]||0)+1;});});
      var data=Object.entries(byP).sort(function(a,b){return b[1]-a[1];}).slice(0,7).map(function(e,i){return{l:e[0].slice(0,14),v:e[1],c:GC[i%GC.length]};});
      return data.length?(type==='donut'?drawDonut(data,'شخص'):drawHBar(data)):noData();
    });
  }

  /* ══════════ GENERAL CHARTS UPDATE ══════════ */
  function updateGeneral() {
    var countries=[...new Set(buildings.map(function(b){return getCountry(b);}).filter(Boolean))];
    var el=document.getElementById('stat-countries-count');
    if(el) el.textContent=countries.length||'—';
    var listEl=document.getElementById('stat-countries-list');
    if(listEl&&countries.length){
      var bgColors=['var(--gold-bright)','var(--gold-mid)','var(--gold-deep)','var(--text-muted)'];
      listEl.innerHTML=countries.slice(0,5).map(function(c,i){
        return '<div style="display:flex;align-items:center;gap:8px;"><span style="width:8px;height:8px;border-radius:50%;background:'+bgColors[Math.min(i,3)]+';display:inline-block;"></span><span style="font-size:calc(12px * var(--fs-scale));color:var(--text-secondary);">'+c+'</span></div>';
      }).join('');
    }
  }

  /* ══════════ INIT ══════════ */
  function init() {
    try { initFinCharts(); } catch(e){ console.warn('fin charts error:',e); }
    try { initAdmCharts(); } catch(e){ console.warn('adm charts error:',e); }
    try { updateGeneral(); } catch(e){ console.warn('general update error:',e); }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    setTimeout(init, 150);
  }

})();

/* ── Mobile Nav Controller ── */
(function () {
  const drawer   = document.getElementById('mob-nav-drawer');
  const overlay  = document.getElementById('mob-nav-overlay');
  const moreTab  = document.getElementById('mobtab-more');
  const moreIcon = document.getElementById('mobtab-more-icon');
  let   drawerOpen = false;

  const ICONS = {
    open:  '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>',
    close: '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>'
  };

  window.mobNavToggleDrawer = function () {
    drawerOpen ? window.mobNavCloseDrawer() : window.mobNavOpenDrawer();
  };

  window.mobNavOpenDrawer = function () {
    drawerOpen = true;
    drawer.classList.add('open');
    drawer.setAttribute('aria-hidden', 'false');
    overlay.classList.add('visible');
    moreTab.classList.add('active');
    moreIcon.innerHTML = ICONS.close;
  };

  window.mobNavCloseDrawer = function () {
    drawerOpen = false;
    drawer.classList.remove('open');
    drawer.setAttribute('aria-hidden', 'true');
    overlay.classList.remove('visible');
    moreTab.classList.remove('active');
    moreIcon.innerHTML = ICONS.open;
  };

  /* Navigate and update active states */
  window.mobNavGo = function (page, options, subPage) {
    // Close drawer first
    window.mobNavCloseDrawer();

    // Call the existing goToPage
    if (options) {
      goToPage(page, options);
    } else {
      goToPage(page);
    }

    // If sub-page navigation needed, trigger sub-item click
    if (subPage) {
      setTimeout(function () {
        const subBtn = document.querySelector(
          '.sidebar-nav .nav-subitem[title*="' + ({
            owners:        'تقرير المالك',
            properties:    'تقرير عقارات',
            attachments:   'تقرير الملحقات',
            consultations: 'تقرير الإشارات'
          }[subPage] || '') + '"]'
        );
        if (subBtn) subBtn.click();
      }, 80);
    }

    // Sync tab active state
    syncMobTabs(page, options);

    // Sync drawer button active state
    syncMobDrawerBtns(page, options, subPage);
  };

  function syncMobTabs(page, options) {
    document.querySelectorAll('.mob-nav-tab:not(#mobtab-more)').forEach(function (t) {
      t.classList.remove('active');
    });
    const map = {
      'reports-home': 'mobtab-properties',
      properties: 'mobtab-properties',
      'stats-home': 'mobtab-dashboard',
      dashboard: 'mobtab-dashboard',
      'stats-generator': 'mobtab-dashboard',
      activity: 'mobtab-properties'
    };
    const id = map[page];
    if (id) {
      const el = document.getElementById(id);
      if (el) el.classList.add('active');
    }
  }

  function syncMobDrawerBtns(page, options, subPage) {
    document.querySelectorAll('.mob-drawer-btn').forEach(function (b) {
      b.classList.remove('active');
    });
    if (subPage) {
      const idMap = { owners: 'mdb-owners', properties: 'mdb-properties', attachments: 'mdb-attachments', consultations: 'mdb-consultations' };
      const el = document.getElementById(idMap[subPage]);
      if (el) el.classList.add('active');
    } else if (page === 'dashboard' && options && options.stats) {
      const sMap = { financial: 'mdb-financial', administrative: 'mdb-administrative', general: 'mdb-general', all: null };
      const el = document.getElementById(sMap[options.stats]);
      if (el) el.classList.add('active');
    } else if (page === 'stats-generator') {
      const el = document.getElementById('mdb-generator');
      if (el) el.classList.add('active');
    } else if (page === 'activity') {
      const el = document.getElementById('mdb-activity');
      if (el) el.classList.add('active');
    }
  }

  /* Patch goToPage to keep mob tabs in sync when called from elsewhere */
  const _origGoToPage = window.goToPage;
  if (typeof _origGoToPage === 'function') {
    window.goToPage = function (page, options) {
      _origGoToPage(page, options);
      syncMobTabs(page, options);
    };
  }
})();

    const __viewerInit = () => {
        if (typeof initializeApp === 'function') {
            initializeApp();
        }
    };

    document.addEventListener('DOMContentLoaded', __viewerInit, { once: true });
    document.addEventListener('livewire:navigated', __viewerInit);
})();
