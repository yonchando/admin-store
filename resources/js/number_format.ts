import { usePage } from "@inertiajs/vue3";

export const currency = (number: string | number, isSign: boolean = true): string | number => {
    const page = usePage();

    if (isSign) {
        return `${page.props.currency.symbol}${number}`;
    }
    return `${number} ${page.props.currency.code}`;
};
