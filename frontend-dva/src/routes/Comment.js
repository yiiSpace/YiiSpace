import React from 'react';
import { connect } from 'dva';
import styles from './Comment.css';
import CommentComponent from '../components/Comment/Comment';
import MainLayout from '../components/MainLayout/MainLayout';

function Comment({ location }) {
return (
<MainLayout location={location}>
    <div className={styles.normal}>
        <CommentComponent />
    </div>
</MainLayout>
);
}

export default connect()(Comment);
