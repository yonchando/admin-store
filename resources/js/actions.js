import {faPencil, faPlus, faRefresh, faSave, faTrash} from "@fortawesome/free-solid-svg-icons";

export default function useActions(params,actionProp = {}) {
    let actions = [
        {
            code: 'create',
            label: "New",
            icon: faPlus,
            props: {
                class: "bg-primary border-primary/50 text-white disabled:opacity-50 disabled:cursor-not-allowed",
                onClick: params.create,
                ...actionProp.create
            },
        },
        {
            code: 'save',
            label: 'Save',
            icon: faSave,
            props: {
                class: "bg-primary border-primary/50 text-white disabled:opacity-50 disabled:cursor-not-allowed",
                onClick: params.save,
                ...actionProp.save
            },
        },
        {
            code: 'update',
            label: "Edit",
            icon: faPencil,
            props: {
                class: "bg-warning text-white disabled:opacity-50 disabled:cursor-not-allowed",
                onClick: params.update,
                ...actionProp.update
            },
        },
        {
            code: 'destroy',
            label: "Delete",
            icon: faTrash,
            props: {
                class: "bg-danger text-white disabled:opacity-50 disabled:cursor-not-allowed",
                onClick: params.destroy,
                ...actionProp.destroy
            },
        },
        {
            code: 'refresh',
            label: "Refresh",
            icon: faRefresh,
            props: {
                class: "border border-light-200 text-dark-200 bg-white",
                onClick: params.refresh,
                ...actionProp.refresh
            },
        },
    ];
    
    let action = Object.keys(params);
    
    return actions.filter(item => action.includes(item.code));
}
