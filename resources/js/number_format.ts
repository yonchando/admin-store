import { usePage } from "@inertiajs/vue3";

export function currencyFormat(number: string | number, isSign: boolean = true): string | number {
    const page = usePage();

    if (isSign) {
        return `${page.props.currency.symbol}${number}`;
    }
    return `${number} ${page.props.currency.code}`;
}

export function phoneNumber(number: string, countryCode: string) {
    number = number.match(/.{1,3}/g)?.join(" ") ?? "";
    return `(${countryCode}) ${number}`;
}
