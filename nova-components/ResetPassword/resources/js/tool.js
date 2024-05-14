Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'reset-password',
      path: '/reset-password',
      component: require('./components/Tool'),
    },
  ])
})
