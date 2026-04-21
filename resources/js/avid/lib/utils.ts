import { Avid } from '@/avid/types';
import { Config } from 'ziggy-js';

export function avidRoute(name: string, params?: any, absolute?: boolean, config?: Config) {
    const prefix = (usePage().props.avid as Avid).settings.routePrefix;

    if (! prefix) {
        return route(name, params, absolute, config);
    }

    return route(`${prefix}.${name}`, params, absolute, config);
}
