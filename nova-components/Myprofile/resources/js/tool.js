Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'myprofile',
      path: '/myprofile',
      component: require('./components/Tool'),
    },
  ])
})
