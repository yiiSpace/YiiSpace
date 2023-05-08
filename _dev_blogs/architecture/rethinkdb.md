参考rethinkdb
================

其系统表属于应用的“根” ，应用中其他组件最后终归要有所归 不能独立存在 这些根就是他们的“归处”

系统架构就是要设计这些脉络通道，设计通信法则。

[system-tables](http://www.rethinkdb.com/docs/system-tables/)

~~~
    The Tables
    
        table_config stores table configurations, including sharding and replication. By writing to table_config, you can create, delete, and reconfigure tables.
        server_config stores server names and tags. By writing to this table you can rename servers and assign them tags.
        db_config stores database UUIDs and names. By writing to this table, databases can be created, deleted or modified.
        cluster_config stores the authentication key for the cluster.
        table_status is a read-only table which returns the status and configuration of tables in the system.
        server_status is a read-only table that returns information about the process and host machine for each server.
        current_issues is a read-only table that returns statistics about cluster problems. For details, read the System current issues table documentation.
        jobs lists the jobs—queries, index creation, disk compaction, and other utility tasks—the cluster is spending time on, and also allows you to interrupt running queries.
        stats is a read-only table that returns statistics about the cluster.
        logs is a read-only table that stores log messages from all the servers in the cluster.


~~~