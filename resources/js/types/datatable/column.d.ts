export interface Component {
    el: any;
    props?: any;
}

export interface Column<Type> {
    label: string | ((t: Type) => string);
    field?: any | ((t: Type) => string);
    props?: any;
    sortable?: string;
    notOnTable?: boolean;
    component?: Component;
}
