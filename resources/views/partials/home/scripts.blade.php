{{--
  كل التفاعلات (القائمة المتنقلة، active state، reveal on scroll، أكورديون الأسئلة،
  تشغيل الفيديو) أصبحت مُدارة بالكامل عبر Alpine.js داخل كل partial
  (x-data / x-show / x-intersect / x-collapse)، لذلك لم يعد هناك حاجة
  لأي جافاسكريبت يدوي هنا.

  x-cloak يجب إخفاؤه افتراضياً قبل تحميل Alpine حتى لا يظهر "فلاش" للعناصر.
--}}
<style>[x-cloak] { display: none !important; }</style>
