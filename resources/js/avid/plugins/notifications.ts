import type { Avid } from '@/avid/types';

const ids = ref<string[]>([]);

export const notifications = () => {
    router.on('finish', () => {
        const notifications = (usePage().props.avid as Avid).notifications;

        if (!notifications.length) {
            return;
        }

        for (const notification of notifications) {
            if (ids.value.includes(notification.id)) {
                continue;
            }
            ids.value.push(notification.id);

            const options = {
                title: notification.title,
                message: notification.body,
                duration: notification.duration,
            };

            switch (notification.status) {
                case 'success':
                    notify.success(options);
                    break;

                case 'warning':
                    notify.warning(options);
                    break;

                case 'danger':
                    notify.error(options);
                    break;

                case 'info':
                default:
                    notify.info(options);
                    break;
            }
        }
    });
};
