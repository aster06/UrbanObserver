(function (Drupal,once) {
  Drupal.behaviors.backToTop = {
    attach(context) {
      const buttonTop = once('buttonToTop', '#backToTop', context);

      buttonTop.forEach((e) => {
        window.addEventListener('scroll', function() {
          const heightWindow = window.innerHeight;

          if (window.scrollY > heightWindow * 0.5) {
            e.classList.add('show');
          } else {
            e.classList.remove('show');
          }
        });
        e.addEventListener('click', function() {
          window.scrollTo({ top: 0, behavior: 'smooth' });
        });
      });
    },
  };
})(Drupal,once);
