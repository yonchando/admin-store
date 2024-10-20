type FieldCallback<Type> = (e: Type) => string;

export interface Component {
    el: any;
    label: string;
    props?: any;
}

export interface Column<Type> {
    label: string;
    field?: string | FieldCallback<Type>;
    props?: any;
    component?: Component;
}
