export interface Flash {
    primary: string;
    success: string;
    info: string;
    warning: string;
    error: string;
}

export type FlashKey = keyof Flash;
