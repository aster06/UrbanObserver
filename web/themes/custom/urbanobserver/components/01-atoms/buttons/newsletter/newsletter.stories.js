import button from './newsletter.twig';

import buttonData from './newsletter.yml';

export default { title: 'Atoms/Button/Newsletter' };

export const twig = () => button(buttonData);
