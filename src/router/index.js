import { Navigate, createHashRouter } from 'react-router-dom';

import Settings from '../pages/Settings';
import Log from '../pages/Log';


const router = [
    {
        'path': '/',
        'element': <Log />
    },
    {
        'path': '/settings',
        'element': <Settings />
    }
];

export default createHashRouter(router);
