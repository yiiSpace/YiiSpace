[https://github.com/HugoGiraudel/sass-guidelines](https://github.com/HugoGiraudel)

下面是Sass Guidelines中的内容（Sass Guidelines中文版本）

通常使用7-1模式的结构：7个文件夹，1个文件。基本上，你需要将所有的部件放进7个不同的文件夹和一个位于根目录的文件（通常命名为 main.scss）中——这个文件编译时会引用所有文件夹而形成一个CSS样式表。

sass/
|
|– base/
|   |– _reset.scss       # Reset/normalize
|   |– _typography.scss  # Typography rules
|   ...                  # Etc…
|
|– components/
|   |– _buttons.scss     # Buttons
|   |– _carousel.scss    # Carousel
|   |– _cover.scss       # Cover
|   |– _dropdown.scss    # Dropdown
|   ...                  # Etc…
|
|– layout/
|   |– _navigation.scss  # Navigation
|   |– _grid.scss        # Grid system
|   |– _header.scss      # Header
|   |– _footer.scss      # Footer
|   |– _sidebar.scss     # Sidebar
|   |– _forms.scss       # Forms
|   ...                  # Etc…
|
|– pages/
|   |– _home.scss        # Home specific styles
|   |– _contact.scss     # Contact specific styles
|   ...                  # Etc…
|
|– themes/
|   |– _theme.scss       # Default theme
|   |– _admin.scss       # Admin theme
|   ...                  # Etc…
|
|– utils/
|   |– _variables.scss   # Sass Variables
|   |– _functions.scss   # Sass Functions
|   |– _mixins.scss      # Sass Mixins
|   |– _helpers.scss     # Class & placeholders helpers
|
|– vendors/
|   |– _bootstrap.scss   # Bootstrap
|   |– _jquery-ui.scss   # jQuery UI
|   ...                  # Etc…
|
|
`– main.scss             # primary Sass file


Base文件夹

base/文件夹存放项目中的模板文件。在这里，可以找到重置文件、排版规范文件或者一个样式表（我通常命名为_base.scss）——定义一些HTML元素公认的标准样式。

    _base.scss
    _reset.scss
    _typography.scss

Layout文件夹

layout/文件夹存放构建网站或者应用程序使用到的布局部分。该文件夹存放网站主体（头部、尾部、导航栏、侧边栏...）的样式表、栅格系统甚至是所有表单的CSS样式。

    _grid.scss
    _header.scss
    _footer.scss
    _sidebar.scss
    _forms.scss
    _navigation.scss

    layout/文件夹也会被称为partials/, 具体使用情况取决于个人喜好。

Components文件夹

对于小型组件来说，有一个components/文件夹来存放。相对于layout/的宏观（定义全局线框结构），components/更专注于局部组件。该文件夹包含各类具体模块，基本上是所有的独立模块，比如一个滑块、一个加载块、一个部件……由于整个网站或应用程序主要由微型模块构成，components/中往往有大量文件。

    _media.scss
    _carousel.scss
    _thumbnails.scss

    components/文件夹也会被称为modules/, 具体使用情况取决于个人喜好。

Pages文件夹

如果页面有特定的样式，最好将该样式文件放进pages/文件夹并用页面名字。例如，主页通常具有独特的样式，因此可以在pages/下包含一个_home.scss以实现需求。

    _home.scss
    _contact.scss

    取决于各自的开发流程，这些文件可以使用你自己的前缀命名，避免在最终样式表中与他人的样式表发生合并。一切完全取决于你。

Themes文件夹

在大型网站和应用程序中，往往有多种主题。虽有多种方式管理这些主题，但是我个人更喜欢把它们存放在themes/文件夹中。

    _theme.scss
    _admin.scss

    这个文件夹与项目的具体实现有密切关系，并且在许多项目中是并不存在的。

Utils文件夹

utils/文件夹包含了整个项目中使用到的Sass辅助工具，这里存放着每一个全局变量、函数、混合宏和占位符。

该文件夹的经验法则是，编译后这里不应该输出任何CSS，单纯的只是一些Sass辅助工具。

    _variables.scss
    _mixins.scss
    _functions.scss
    _placeholders.scss (通常命名为_helpers.scss)

    utils/文件夹也会被称为helpers/,sass-helpers/或者sass-utils/，具体使用情况取决于个人喜好。

Vendors文件夹

最后但并非最终的是，大多数的项目都有一个vendors/文件夹，用来存放所有外部库和框架（Normalize, Bootstrap, jQueryUI, FancyCarouselSliderjQueryPowered……）的CSS文件。将这些文件放在同一个文件中是一个很好的说明方式:"嘿，这些不是我的代码，无关我的责任。"

    _normalize.scss
    _bootstrap.scss
    _jquery-ui.scss
    _select2.scss

如果你重写了任何库或框架的部分，建议设置第8个文件夹vendors-extensions/来存放，并使用相同的名字命名。

例如，vendors-extensions/_boostrap.scss文件存放所有重写Bootstrap默认CSS之后的CSS规则。这是为了避免在原库或者框架文件中进行二次编辑——显然不是好方法。
Main文件

主文件（通常写作main.scss）应该是整个代码库中唯一开头不用下划线命名的Sass文件。除 @import和注释外，该文件不应该包含任何其他代码。

文件应该按照存在的位置顺序依次被引用进来：

    vendors/
    utils/
    base/
    layout/
    components/
    pages/
    themes/

为了保持可读性，主文件应遵守如下准则：

    每个 @import引用一个文件；
    每个 @import单独一行；
    从相同文件夹中引入的文件之间不用空行；
    从不同文件夹中引入的文件之间用空行分隔；
    忽略文件扩展名和下划线前缀。

@import 'vendors/bootstrap';
@import 'vendors/jquery-ui';

@import 'utils/variables';
@import 'utils/functions';
@import 'utils/mixins';
@import 'utils/placeholders';

@import 'base/reset';
@import 'base/typography';

@import 'layout/navigation';
@import 'layout/grid';
@import 'layout/header';
@import 'layout/footer';
@import 'layout/sidebar';
@import 'layout/forms';

@import 'components/buttons';
@import 'components/carousel';
@import 'components/cover';
@import 'components/dropdown';

@import 'pages/home';
@import 'pages/contact';

@import 'themes/theme';
@import 'themes/admin';


这里还有另一种引入的有效方式。令人高兴的是，它使文件更具有可读性；令人沮丧的是，更新时会有些麻烦。不管怎么说，由你决定哪一个最好，这没有任何问题。 对于这种方式，主要文件应遵守如下准则：

    每个文件夹只使用一个@import
    每个@import之后都断行
    每个文件占一行
    新的文件跟在最后的文件夹后面
    文件扩展名都可以省略

@import
  'vendors/bootstrap',
  'vendors/jquery-ui';

@import
  'utils/variables',
  'utils/functions',
  'utils/mixins',
  'utils/placeholders';

@import
  'base/reset',
  'base/typography';

@import
  'layout/navigation',
  'layout/grid',
  'layout/header',
  'layout/footer',
  'layout/sidebar',
  'layout/forms';

@import
  'components/buttons',
  'components/carousel',
  'components/cover',
  'components/dropdown';

@import
  'pages/home',
  'pages/contact';

@import
  'themes/theme',
  'themes/admin';


也有很多人建议配合SMACSS（Home - Scalable and Modular Architecture for CSS） 。大家还可以参考一下Foundation和Bootstrap这样的大型前端框架子有关于Sass的文件管理。借别人之力，总结出一套适合自己或自己团队的文件管理结构。

下面摘自了一些相关介绍管理Sass文件的文章，感兴趣的话可以看看：

1、Sass带来的变革
2、管理Sass项目文件结构
3、【Sass初级】如何组织一个Sass项目
4、将你的CSS项目转换成Sass
5、Sass Guidelines中文版本之四：项目文件管理

有关于Sass更多的中文资料：sass | 博客自由标签
有关于Sass的外文资料：FE-Translation/Sass · GitHub 顺便说一下，我们也在致力于将这些外文教程翻译成中文，希望有更多的同学参与到这样的分享活动当中。