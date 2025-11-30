/**
 * スクロールアニメーション用JavaScript
 * 要素が画面内に入ったときにアニメーションを発火させる
 */

document.addEventListener('DOMContentLoaded', function() {
    // スクロールアニメーション対象の要素を取得
    const animateElements = document.querySelectorAll('.animate-on-scroll');

    // Intersection Observer のオプション
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1 // 10%見えたらアニメーション開始
    };

    // Intersection Observer のコールバック
    const observerCallback = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                // 一度アニメーションしたら監視を解除
                observer.unobserve(entry.target);
            }
        });
    };

    // Intersection Observer を作成
    const observer = new IntersectionObserver(observerCallback, observerOptions);

    // 各要素を監視
    animateElements.forEach(element => {
        observer.observe(element);
    });

    // インストラクターセクションの順次アニメーション
    const instructorSections = document.querySelectorAll('#contents > h4, #float_left01, #float_right01');
    instructorSections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.animation = `fadeInUp 0.6s ease ${index * 0.15}s forwards`;
    });

    // お知らせアイテムの順次アニメーション
    const newsItems = document.querySelectorAll('#new dt, #new dd');
    newsItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.animation = `fadeIn 0.5s ease ${index * 0.1}s forwards`;
    });

    // テーブル行のアニメーション
    const tableRows = document.querySelectorAll('.ta1 tr, .ta2 tr, .ta3 tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.animation = `fadeIn 0.4s ease ${index * 0.08}s forwards`;
    });
});

// ページトップへ戻るボタンのスムーズスクロール
document.addEventListener('DOMContentLoaded', function() {
    const scrollTopBtn = document.querySelector('.scroll a');
    if (scrollTopBtn) {
        scrollTopBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});

// メニューのホバーエフェクト強化
document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('#menubar li a, #menubar_top li a');
    menuItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
