import logoObserverMenu from './logo-observer-menu.twig';

import logoObserverNewsletterData from '../../../01-atoms/buttons/newsletter/newsletter.yml';
import logoObserverPricingPlansData from '../../../01-atoms/buttons/pricing-plans/pricing-plans.yml';

export default { title: 'Molecules/Menus/LogoObserverMenu' };

export const logoobservermenu = () =>
  logoObserverMenu({
    ...logoObserverNewsletterData,
    ...logoObserverPricingPlansData,
  });
