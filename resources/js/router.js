import { createRouter, createWebHashHistory } from 'vue-router';

const routes = [
//   {
//     name: 'notFound',
//     path: '/:path(.*)+',
//     redirect: {
//       name: 'goods',
//     },
//   },
  {
    name: 'index',
    path: '/',
    component: () => import('./view/emotiom'),
    meta: {
      title: 'index',
    },
  },
  {
    name: 'user',
    path: '/user',
    component: () => import('./view/mood'),
    meta: {
      title: '会员中心',
    },
  },
];

const router = createRouter({
  routes,
  history: createWebHashHistory(),
});

router.beforeEach((to, from, next) => {
  const title = to.meta && to.meta.title;
  if (title) {
    document.title = title;
  }
  next();
});

export { router };
