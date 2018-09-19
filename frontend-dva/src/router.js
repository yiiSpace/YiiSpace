import React from 'react';
import { Router } from 'dva/router';

const cached = {};
function registerModel(app, model) {
  if (!cached[model.namespace]) {
    app.model(model);
    cached[model.namespace] = 1;
  }
}

function RouterConfig({ history, app }) {
  const routes = [
    {
      path: '/',
      name: 'IndexPage',
      getComponent(nextState, cb) {
        require.ensure([], (require) => {
          cb(null, require('./routes/IndexPage'));
        });
      },
    },
    {
      path: '/users',
      name: 'UsersPage',
      getComponent(nextState, cb) {
        require.ensure([], (require) => {
          registerModel(app, require('./models/users'));
          cb(null, require('./routes/Users'));
        });
      },
    } ,
      {
          path: 'admin-menu',
          name: 'AdminMenuPage',
          getComponent(nextState, cb) {
              require.ensure([], (require) => {
                  registerModel(app, require('./models/adminMenu'));
                  cb(null, require('./routes/AdminMenu'));
              });
          },
      },
      {
          path: 'comment',
          name: 'CommentPage',
          getComponent(nextState, cb) {
              require.ensure([], (require) => {
                  registerModel(app, require('./models/comment'));
                  cb(null, require('./routes/Comment'));
              });
          },
      },

  ];

  return <Router history={history} routes={routes} />;
}

export default RouterConfig;
