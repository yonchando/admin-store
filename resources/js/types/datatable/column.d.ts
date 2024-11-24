export interface Component<Type> {
    el: any;
    props?: any | ((t: Type) => any);
}

export interface ColumnType<Type> {
    label: string | ((t: Type) => string);
    field?: keyof Type | ((t: Type) => any);
    props?: any;
    sortable?: keyof Type | ((t: Type) => any);
    component?: Component<Type>;
    hideFromIndex?: boolean;
}
