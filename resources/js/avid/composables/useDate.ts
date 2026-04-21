
export function useDate() {
    const formatDateTime = (date: string | null | undefined) => {
        if (!date) {
            return '';
        }

        return (new Date(date)).toLocaleDateString("it-IT", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit"
        });
    }

    const formatDate = (date: string | null | undefined) => {
        if (!date) {
            return '';
        }

        return (new Date(date)).toLocaleDateString(undefined, {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
        });
    };

    const formatTime = (date: string | null | undefined) => {
        if (!date) {
            return '';
        }

        return (new Date(date)).toLocaleTimeString(undefined, {
            hour: "2-digit",
            minute: "2-digit"
        });
    };

    return {
        formatDateTime,
        formatDate,
        formatTime,
    }
}
