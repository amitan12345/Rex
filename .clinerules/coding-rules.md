# コーディング規約（PHP）

## クラス定義
- コンストラクタのプロモーションによってクラスのプロパティを宣言すること
- 可能ならプロパティをreadonlyにすること
- クラスプロパティのGetter、SetterはPHP8.4で追加された非対称可視性によって定義すること。この場合、コンストラクタのプロモーションでプロパティを定義しなくて良い。
- `declare(strict_type=1);`を記載すること

## テストコードについて
- Infrastructureのテストコードにおいて、EloquentModelのモックは絶対に行ってはいけません。
- Domain層のEntity、ValueObject, Aggregationは絶対にモックしてはいけません。