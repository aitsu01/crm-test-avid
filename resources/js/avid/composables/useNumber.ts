export function useNumber () {
    const formatNumber = (value: number, locale: string = 'it-IT') => {
        var formatter = new Intl.NumberFormat(locale, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });
        return formatter.format(value);
    };

    const formatCurrency = (value: number, currency: string = 'EUR', locale: string = 'it-IT') => {
        var formatter = new Intl.NumberFormat(locale, {
            style: "currency",
            currency: currency,
            minimumFractionDigits: 2,
        });
        return formatter.format(value);
    };

    return {
        formatNumber,
        formatCurrency,
    }
}
