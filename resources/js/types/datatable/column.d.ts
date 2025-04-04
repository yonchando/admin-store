export interface Component<Type> {
    el: any;
    props?: any | ((t: Type) => any);
}

export interface ColumnType<Type> {
    label: string | ((t: Type) => string);
    field?: keyof Type | ((t: Type) => any) | string;
    props?: any;
    sortable?: keyof Type | ((t: Type) => any);
    filters?: {
        field: string;
        component: Component<any>;
    };
    component?: Component<Type>;
    hideFromIndex?: boolean;
}
