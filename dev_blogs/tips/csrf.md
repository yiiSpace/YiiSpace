>
    Cross-site request forgery (CSRF) attacks are conducted by targeting a URL that has
    side effects (that is, it is performing an action and not just displaying information).
    We have already partly mitigated CSRF attacks by avoiding the use of GET for routes
    that have permanent effects such as DELETE/cats/1, since it is not reachable from a
    simple link or embeddable in an <iframeiframe> element. However, if an attacker is able
    to send his victim to a page that he controls, he can easily make the victim submit a
    form to the target domain. If the victim is already logged in on the target domain, the
    application would have no way of verifying the authenticity of the request.