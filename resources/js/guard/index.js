import store from '@/store';

export const adminGuard = async (to, from, next) => {
    await store.dispatch('auth/fetch', null, {root: true});
    let isAdmin = store.getters['auth/user'].isAdmin;
    if (isAdmin) {
        next()
    }
    else {
        next({name: 'NotFound'});
    }
};



