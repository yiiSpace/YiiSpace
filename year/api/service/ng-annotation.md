
通过看文档 可以粗略知道 annotation咋回事

@see https://v2.angular.io/docs/ts/latest/cookbook/ts-to-js.html

随便考一段不同语言间的转换

- Ts

~~~js

import { Component } from '@angular/core';
@Component({
  selector: 'hero-view',
  template: '<h1>{{title}}: {{getName()}}</h1>'
})
export class HeroComponent {
  title = 'Hero Detail';
  getName() {return 'Windstorm'; }
}


~~~

- Es6 带注解

~~~js

import { Component } from '@angular/core';
@Component({
  selector: 'hero-view',
  template: '<h1>{{title}}: {{getName()}}</h1>'
})
export class HeroComponent {
  title = 'Hero Detail';
  getName() {return 'Windstorm'; }
}

~~~

- Es6 

不带注解  可以看到注解实际是可以通过作为 类HeroComponent静态属性：annotations集合来变相实现的

~~~js

import { Component } from '@angular/core';
export class HeroComponent {
  constructor() {
    this.title = 'Hero Detail';
  }
  getName() {return 'Windstorm'; }
}
HeroComponent.annotations = [
  new Component({
    selector: 'hero-view',
    template: '<h1>{{title}}: {{getName()}}</h1>'
  })
];


~~~

- Es5

~~~js

app.HeroComponent = HeroComponent; // "export"
HeroComponent.annotations = [
  new ng.core.Component({
    selector: 'hero-view',
    template: '<h1>{{title}}: {{getName()}}</h1>'
  })
];
function HeroComponent() {
  this.title = "Hero Detail";
}
HeroComponent.prototype.getName = function() { return 'Windstorm'; };

~~~

