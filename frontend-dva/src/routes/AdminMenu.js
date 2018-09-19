import React from 'react';
import { connect } from 'dva';
import styles from './AdminMenu.css';
import AdminMenuComponent from '../components/AdminMenu/AdminMenu';
import MainLayout from '../components/MainLayout/MainLayout';

function AdminMenu({ location }) {
return (
<MainLayout location={location}>
    <div className={styles.normal}>
        <AdminMenuComponent />
    </div>
</MainLayout>
);
}

export default connect()(AdminMenu);
