import buttonPricing from './see-pricing.twig';

import buttonPricingData from './see-pricing.yml';

export default { title: 'Atoms/Button/See Pricing' };

export const twig = () => buttonPricing(buttonPricingData);
