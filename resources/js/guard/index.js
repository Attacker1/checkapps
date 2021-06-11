import store from '@/store';
import Permissions from '@/utils/permissions';

export const adminGuard = async (to, from, next) => {
    await store.dispatch('auth/fetch', null, {root: true});
    let permissions = store.getters['auth/user'].permissions;
    // console.log(permissions.find(item => item.slug === 'can_verivy_checks') ? 'asd' : 'no');
    switch(to.name) {
        case 'Main':
            isHavePermission(permissions, Permissions.verifyChecks) ? next() : next({name: 'Admin'});
            break;
        case 'History':
            isHavePermission(permissions, Permissions.verifyChecks) ? next() : next({name: 'Admin'});
            break;
        case 'Admin':
            isHavePermission(permissions, Permissions.viewAdminPages) ? next() : next({name: 'NotFound'});
            break;
        case 'Settings':
            isHavePermission(permissions, Permissions.editSettings) ? next() : next({name: 'NotFound'});
            break;
    }
    next();
};

function isHavePermission (permissions, yourPermission) {
    return !!permissions.find(item => item.slug === yourPermission);
}
