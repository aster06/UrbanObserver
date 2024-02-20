import buttons from './pricing-plans.twig';

import buttonsData from './pricing-plans.yml';

export default { title: 'Atoms/Button/Pricing plans' };

export const twig = () => buttons(buttonsData);
