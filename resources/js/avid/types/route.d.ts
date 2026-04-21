declare global {
    let avidRoute: (typeof import('../avid/lib/utils'))['avidRoute'];
}

declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        avidRoute: typeof avidRoute;
    }
}
