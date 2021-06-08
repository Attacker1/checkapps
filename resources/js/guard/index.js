import store from '@/store';

export const adminGuard = async (to, from, next) => {
    await store.dispatch('auth/fetch', null, {root: true});
    let isAdmin = store.getters['auth/user'].is_admin;
    switch(to.name) {
        case 'Main':
            isAdmin ? next({name: 'Admin'}) : next();
            break;
        case 'History':
            isAdmin ? next({name: 'Admin'}) : next();
            break;
        case 'Admin':
            isAdmin ? next() : next({name: 'NotFound'});
            break;
    }
    next();
};



