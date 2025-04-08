# Active Context: Rex

## Current Work Focus

Rexプロジェクトは現在、初期セットアップフェーズにあります。スプリント1では以下のゴールに焦点を当てています：

1. composerで必要なライブラリを追加する
2. PHP、Nginx、DBのDockerコンテナを作成し、ping-pong APIを実行できる状態にする
3. 企業のサインアップ機能の実装
4. 企業のサインイン機能の実装
5. 企業のサインアウト機能の実装

### Current Priorities
1. 企業関連の認証機能を実装する
   - サインアップ
   - サインイン
   - サインアウト
2. クリーンアーキテクチャのディレクトリ構造を拡張する
3. データベースマイグレーションを実装する

## Recent Changes

プロジェクトはLaravel 12.0で初期化され、基本的なディレクトリ構造が整っています。メモリバンクが作成され、プロジェクトのアーキテクチャ、コンテキスト、進捗を文書化しています。

スプリント1の一部として、以下のライブラリを追加しました：
- **laravel/sanctum**: API認証用（`^4.0`）
- **phpstan/phpstan**: 静的解析用（`^2.1`）
- **squizlabs/php_codesniffer**: コーディング標準チェック用（`^3.12`）

また、以下の設定ファイルを作成しました：
- **phpstan.neon**: PHPStanの設定（Level 9）
- **phpcs.xml**: PHP_CodeSnifferの設定（PSR-12ベース）

Sanctumの設定ファイルとマイグレーションも公開しました。

Docker環境を構築するために以下のファイルを作成しました：
- **docker-compose.yml**: PHP、Nginx、MySQLコンテナの定義
- **docker/php/Dockerfile**: PHPコンテナのカスタム設定
- **docker/php/local.ini**: PHP設定
- **docker/nginx/default.conf**: Nginx設定

また、クリーンアーキテクチャに従って以下のコンポーネントを実装しました：
- **app/Framework/Http/Controllers/Controller.php**: ベースコントローラークラス
- **app/Presentation/Api/Ping/PingController.php**: Ping-Pong APIコントローラー
- **routes/api/ping.php**: Ping-Pong APIルート

## Next Steps

### Immediate Tasks
1. 企業のサインアップ機能を実装する
   - 企業エンティティの定義
   - サインアップユースケースの実装
   - APIエンドポイントの作成
2. 企業のサインイン機能を実装する
   - 認証ロジックの実装
   - トークン発行の実装
3. 企業のサインアウト機能を実装する
   - トークン無効化の実装

### Upcoming Work
1. 企業情報の閲覧・更新・退会機能の実装
2. 求人の作成・編集・削除・閲覧機能の実装
3. 求職者のサインアップ・サインイン・サインアウト機能の実装
4. 求職者情報の閲覧・更新機能の実装
5. 求人応募と応募キャンセル機能の実装
6. 求人応募一覧の確認と選考機能の実装

## Active Decisions and Considerations

### Architecture Decisions
- **クリーンアーキテクチャの実装**: プロジェクトガイドラインで定義された構造に従う
- **レイヤー分離**: レイヤー間の依存関係ルールの厳格な遵守
- **リポジトリパターン**: アプリケーション全体でのデータアクセスに使用
- **ユースケースパターン**: ビジネス操作のカプセル化

### Technical Decisions
- **Dockerベースの開発**: 一貫した開発環境のためにDockerを使用
- **テスト戦略**: ビジネスロジックの単体テスト、統合ポイントの機能テスト
- **静的解析**: 厳格な型チェックのためのPHPStan Level 9
- **コードスタイル**: 一貫したコードフォーマットのためのPHP_CodeSniffer

## Important Patterns and Preferences

### Coding Patterns
- **Value Objects**: アイデンティティのない概念を表す不変オブジェクト
- **Entities**: アイデンティティとライフサイクルを持つオブジェクト
- **Aggregations**: 単位として扱われるドメインオブジェクトのクラスター
- **Use Cases**: ビジネス操作のための単一責任クラス
- **Repositories**: データアクセスのためのコレクションのようなインターフェース

### Naming Conventions
- **Classes**: PascalCase、説明的な名前
- **Methods**: camelCase、動詞フレーズ
- **Variables**: camelCase、名詞フレーズ
- **Interfaces**: PascalCase、'I'で始まるか'Interface'で終わる
- **Tests**: PascalCase、'Test'で終わる

### File Organization
- **Domain Layer**: コアビジネスロジックとエンティティ
- **Application Layer**: ユースケースとアプリケーションサービス
- **Infrastructure Layer**: 外部システムとデータアクセス
- **Presentation Layer**: コントローラーとAPIエンドポイント
- **Framework Layer**: フレームワーク固有のコンポーネント

## Learnings and Project Insights

### Key Insights
- クリーンアーキテクチャは明確な関心の分離を提供
- ドメイン駆動設計は複雑なビジネスプロセスのモデル化に役立つ
- リポジトリパターンはビジネスロジックからデータアクセスを抽象化
- ユースケースパターンはビジネス操作をカプセル化

### Challenges
- 厳格なレイヤー分離の維持には規律が必要
- ドメインモデリングにおける柔軟性と複雑さのバランス
- すべてのレイヤーにわたる包括的なテストカバレッジの確保
- コンポーネント間の依存関係の管理

### Best Practices
- 機能を実装する前にテストを書く
- 不変の概念にはバリューオブジェクトを使用
- ドメインロジックをフレームワークから独立させる
- 疎結合のために依存性注入を使用
- アーキテクチャの決定とパターンを文書化する
