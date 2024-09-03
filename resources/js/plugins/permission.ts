import { App } from 'vue';
import { Permission } from "@/types";


export default {
    install(app: App) {
        app.config.globalProperties.$can = (permission:string) : boolean => {
            return app.config.globalProperties.$page.props.auth.permissions
                .findIndex((per:Permission) : boolean => per.name === permission) !== -1;
        }
    },
};
