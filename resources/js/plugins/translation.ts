import {App, provide} from 'vue';
import {Translation} from "@/types";
import {usePage} from "@inertiajs/vue3";



export default {
    install(app: App) {

        app.mixin({
            beforeCreate() {
                const translations:Translation = usePage().props?.translations;
                if (translations) {
                    provide('$trans', (value: string): string => {
                        return translations[value] != null ? translations[value] : value;
                    });
                }
            }
        });

        app.config.globalProperties.$trans = (value:string) : string => {
            const array:Translation = app.config.globalProperties.$page.props.translations
            return array[ value ] != null ? array[ value ] : value;
        }
    },
};
