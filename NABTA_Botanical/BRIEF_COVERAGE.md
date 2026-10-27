# مطابقة واجهات نبتة مع البريف

هذه نسخة HTML/CSS من الواجهات؛ لا تمثل تسليم مشروع PHP المكتمل.

| متطلب البريف | مكانه في النسخة | الحالة |
|---|---|---|
| Navbar مع Login/Register | جميع صفحات المتجر | روابط فعلية |
| Slider للعروض | index.html: ثلاثة عروض | يعمل بـ HTML/CSS، دون تشغيل تلقائي |
| قسم خصومات | index.html وصفحة Desk Garden | عرض السعر السابق والحالي |
| التسجيل والدخول | register.html / login.html | واجهة، يحتاج PHP |
| Google Auth | زر Google في صفحتي الدخول والتسجيل | واجهة، يحتاج OAuth |
| الملف الشخصي | profile.html | عرض ونافذة تعديل؛ الحفظ لاحقًا |
| Admin / Regular User | صفحات الحساب ولوحة الإدارة وحقول الدور | واجهة؛ فرض الصلاحيات يحتاج جلسات PHP |
| تصفح المنتجات وتفاصيلها | products.html و6 صفحات منتجات | روابط فعلية ومحتوى عينة |
| البحث بالاسم والتصنيف والسعر | products.html + نافذة الفلاتر | حقول الواجهة؛ تطبيق الفلاتر لاحقًا |
| التعليقات والتقييمات | صفحات المنتجات وadmin-reviews.html | عرض/نماذج؛ الحفظ لاحقًا |
| الإضافة للسلة وعرضها | صفحات المنتجات وcart.html | نوافذ وروابط؛ السلة عينة |
| تحديث وحذف عناصر السلة | cart.html | حقول كميات وأزرار؛ لا تحديث حسابي |
| Checkout | checkout.html | بيانات التوصيل ونافذة المراجعة |
| إدارة الطلبات | orders.html وadmin-orders.html | عرض وإنشاء وتعديل وحذف كواجهات |
| لوحة الإحصائيات | admin.html | دخل/تصنيفات/طلبات/عملاء/جدول إيراد يومي، بيانات عينة |
| CRUD المنتجات | admin-products.html | View / Add / Edit / Delete ونوافذ مستقلة |
| CRUD التصنيفات | admin-categories.html | View / Add / Edit / Delete |
| CRUD المستخدمين | admin-users.html | View / Add / Edit / Delete |
| CRUD الطلبات | admin-orders.html | View / Add / Edit / Delete |
| إدارة المراجعات والتقييمات | admin-reviews.html | النشر والإخفاء والتعديل والحذف كواجهات |
| ميزة AI | assistant.html | وصف المكان والإضاءة والميزانية + أمثلة اقتراحات |
| Responsive | CSS مشترك وmedia queries | معاينة على الكمبيوتر و390px |
| بيع وشراء وفق الفكرة الجديدة | sell.html / my-listings.html | نموذج إعلان ومتابعته؛ مراجعة ضمن إدارة المنتجات |

## متطلبات مرحلة البرمجة ولم تُنفذ بسبب شرط HTML/CSS فقط
PHP OOP، MySQL، PDO، قاعدة البيانات العلائقية، الجلسات، Password hashing، التحقق الخادمي، prepared statements، حماية SQL Injection وXSS، protected routes، Google OAuth، استدعاء AI، وتنفيذ CRUD وعمليات الشراء فعليًا.

## تسليمات أكاديمية منفصلة
ملفات Wireframe/Mockup، ERD، Trello لكل عضو، عرض تقديمي ورابط المستودع أو الموقع ليست مُنشأة ضمن ملف واجهات HTML/CSS هذا. الواجهات لا تستبدل هذه التسليمات.
