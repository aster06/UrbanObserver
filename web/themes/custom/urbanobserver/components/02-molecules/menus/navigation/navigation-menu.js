Drupal.behaviors.mainMenu = {
  attach(context) {
    const toggleExpand = once('toggle-expand', '#toggle-expand', context);
    const menu = once('navigation-nav', '#navigation-nav', context);
    const logo = once('nav-logo', '#nav-logo', context);
    const littlePreMenu = once('lower-block', '.little-pre-menu', context);
    const searchIcon = once('search-icon', '#search-icon', context);
    const searchForm = once('search-block-form', '#block-urbanobserver-search-form-wide', context);
    const pricingButton = once('see-pricing', '.button-see-pricing', context);
    const socialLinks = once('social-links', '#social-links', context);

    toggleExpand.forEach((el) => {
      el.addEventListener('click', (e) => {
        toggleExpand.forEach((toggle) =>
          toggle.classList.toggle('toggle-expand--open'),
        );
        menu.forEach((m) => m.classList.toggle('navigation-nav--open'));
        logo.forEach((l) => l.classList.toggle('menu-logo--open'));
        searchIcon.forEach((si) => si.classList.toggle('search-icon--open-menu'));
        littlePreMenu.forEach((lm) => lm.classList.toggle('little-pre-menu--open'));
        pricingButton.forEach((pb) => pb.classList.toggle('button-see-pricing--open'));
        socialLinks.forEach((sl) => sl.classList.toggle('social-links--open'));
        e.preventDefault();
      });
    });

    searchIcon.forEach((i) => {
      i.addEventListener('click', (e) => {
        searchIcon.forEach((icon) =>
          icon.classList.toggle('search-icon--open'),
        );
        searchForm.forEach((ib) => ib.classList.toggle('search-block-form--open'));
        e.preventDefault();
      });
    });
  },
};
