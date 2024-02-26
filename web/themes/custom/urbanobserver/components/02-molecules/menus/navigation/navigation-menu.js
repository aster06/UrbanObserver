Drupal.behaviors.mainMenu = {
  attach(context) {
    const toggleExpand = once('toggle-expand', '#toggle-expand', context);
    const navRegionMenu = once('nav-region', '.nav-region', context);
    const searchIcon = once('search-icon', '#search-icon', context);
    const searchForm = once('search-block-form', '#block-urbanobserver-search-form-wide', context);

    toggleExpand.forEach((el) => {
      el.addEventListener('click', (e) => {
        toggleExpand.forEach((toggle) =>
          toggle.classList.toggle('toggle-expand--open'),
        );
        navRegionMenu.forEach((a) => a.classList.toggle('nav-class--open'));
        searchIcon.forEach((si) => si.classList.toggle('search-icon--open-menu'));
        searchForm.forEach((ib) => ib.classList.toggle('search-block-form--opens'));
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
