[fwdays-i18n-l10n](http://slides.rmcreative.ru/2015/fwdays-i18n-l10n/#/45)
i18n的表设计模式：

-  Many columns
    
    post (id,status, title_en,title_de, text_en,text_de ...)
    
    ### 缺点
        
    - Complex query
    - Hard to add languages
    
- Same table, multiple records
    
    post( id , title , text , language )
    
    ###   缺点
    - ! Each language record is a separate independent one
    + Simple
    + Easy to add translations


- Single record + translation in another table

    post( id status )  ----------<>  post_trans(id,post_id,language , title , text )
    
    ### 优点
    
    + Simple maintenance
    + Easy to add translations
    + Only one join
