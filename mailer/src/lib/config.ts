import { PUBLIC_SUBJECT } from '$env/static/public';
import { env } from '$env/dynamic/public';

export const PUBLIC_TEST_EMAIL = env.PUBLIC_TEST_EMAIL || '';
export { PUBLIC_SUBJECT };
