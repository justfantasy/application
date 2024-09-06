import { createBrowserRouter } from 'react-router-dom';

import Login from '@/pages/Login';

const router = createBrowserRouter([
  {
    path: '/login',
    element: <Login />,
  },
  {
    path: '/',
    element: <div>About</div>,
  },
]);

export default router;
