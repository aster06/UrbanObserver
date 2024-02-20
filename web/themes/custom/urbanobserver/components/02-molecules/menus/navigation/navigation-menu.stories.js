import navigation from './navigation-menu.twig';

import navigationData from './navigation-menu.yml';
import littlePreMenuData from '../little-pre-menu/little-pre-menu.yml';
import buttonPricingData from '../../../01-atoms/buttons/see-pricing/see-pricing.yml';

import './navigation-menu';

export default { title: 'Molecules/Menus/Navigation' };

export const navigations = () =>
  navigation({
    ...navigationData,
    ...littlePreMenuData,
    ...buttonPricingData,
  });
