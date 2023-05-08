17:50:02
小刚 2016/8/9 17:50:02
select aid
        from B
        left join A
        on B.id=A.id
        where A.id is null
小刚 2016/8/9 17:50:43
select *
        from B
        left join A
        on B.id=A.id
        where A.id is null
小刚 2016/8/9 17:50:47
求差集。 
小刚 2016/8/9 17:51:01
用left join
17:52:03
小刚 2016/8/9 17:52:03
select *
        from B
        left join A
        on B.id=A.id
        where A.id is nul   求出B－A的差集。