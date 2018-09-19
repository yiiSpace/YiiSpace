enum HelloLanguage {
        ENGLISH,
        FRENCH,
        SPANISH
}

service HelloService {
        string say_hello(),
        string say_foreign_hello(1: HelloLanguage language),
        list<string> say_hello_repeat(1: i32 times),
}