import {computed} from "vue";
import {faPlus} from "@fortawesome/free-solid-svg-icons";

export default function useActions(params){
    const actions = [
        {
            label: "New",
            icon: faPlus,
            command: () => {
                params.create();
            }
        },
        {
            label: "Refresh",
            icon: faPlus,
            command: () => {
                params.refresh();
            }
        }
    ];
    return computed(() => {
        return [
            
        ]
    })
}