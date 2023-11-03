import { GOOGLE_AUTH } from '$env/static/private';
import type { GoogleAuthKey } from './google-auth.d';

export function googleAuthConfig(): GoogleAuthKey {
	return JSON.parse(GOOGLE_AUTH);
}
