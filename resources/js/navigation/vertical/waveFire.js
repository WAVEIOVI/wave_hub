export default [
  {
    title: 'Wave Fire',
    icon: { icon: 'tabler-flame' },
    children: [
      {
        title: 'Dashboard',
        to: null,
      },
      {
        title: 'Contract',
        to: null,
      },
      {
        title: 'Mission',
        children: [
          {
            title: 'Planning',
            to: 'wave-fire-mission-mission-planning-calendar',
          },
          {
            title: 'Mission Folder',
            to: 'wave-fire-mission-mission-folder-list',
          },
          {
            title: 'Intervention',
            to: 'wave-fire-mission-intervention-list',
          },
          
          {
            title: 'Workshop',
            to: 'wave-fire-mission-workshop-list',
          },
        ],
      },
      {
        title: 'Inventory',
        children: [
          {
            title: 'Fire Park',
            to: 'wave-fire-inventory-fire-park-list',
          },
          {
            title: 'Life Sheet',
            to: null,
          },
        ],
      },
    ],
  },
]
  