import store from '@/store';

export const adminGuard = async (to, from, next) => {
    await store.dispatch('auth/fetch', null, {root: true});
    let slug = store.getters['auth/user'].role.slug;
    if (slug === 'admin') {
        next()
    }
    else {
        next({name: 'NotFound'});
    }
};



