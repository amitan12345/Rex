# Technical Context: Rex

## Technology Stack

### Backend
- **PHP**: バージョン 8.4.0 以上
- **Laravel**: バージョン 12.0.0 以上
- **MySQL**: バージョン 8.4 以上
- **PHPStan**: バージョン 2.1 以上 (Level 9)
- **PHP_CodeSniffer**: バージョン 3.12 以上

### Infrastructure
- **Docker**: コンテナ化プラットフォーム
- **Nginx**: バージョン 1.27.0 以上 (Webサーバー)

### Development Tools
- **Composer**: PHP依存関係管理
- **Laravel Tinker**: LaravelのREPL
- **Laravel Pail**: ログビューワー
- **Laravel Pint**: PHPコードスタイル修正ツール
- **Laravel Sail**: Docker開発環境
- **PHPUnit**: バージョン 11.5.3 以上 (テストフレームワーク)
- **Mockery**: テスト用モッキングフレームワーク
- **Faker**: テストデータ生成
- **Collision**: CLIエラーハンドリング

## Development Environment

### Container Setup
アプリケーションは3つの主要なサービスを持つコンテナ化環境で実行されます：

1. **PHPコンテナ**:
   - Laravelアプリケーションを実行
   - PHP 8.4.0 以上
   - 依存関係管理のためのComposer

2. **Nginxコンテナ**:
   - HTTPリクエストを処理
   - PHPコンテナにトラフィックをルーティング
   - 静的アセットを提供

3. **データベースコンテナ**:
   - MySQL 8.4 以上を実行
   - アプリケーションデータを永続化

### Local Development
開発はLaravel Sailを通じて促進され、Dockerベースの開発環境を提供します：

```bash
# 開発環境を起動
./vendor/bin/sail up

# Artisanコマンドを実行
./vendor/bin/sail artisan migrate

# テストを実行
./vendor/bin/sail test
```

あるいは、composerスクリプトを使用することもできます：

```bash
# 開発サーバーを起動
composer dev
```

これにより以下が実行されます：
- Laravel開発サーバー
- キューワーカー
- ログビューワー
- フロントエンドアセット用のVite

## Technical Constraints

### Code Quality
- すべてのコードはPHPStan Level 9に合格する必要がある
- すべてのコードはPHP_CodeSnifferのルールに準拠する必要がある
- すべての新しいコードは対応するテストを含む必要がある

### Architecture
- クリーンアーキテクチャの原則に従う必要がある
- 定義されたレイヤー構造に従う必要がある
- 各レイヤーは内側のレイヤーにのみ依存し、外側のレイヤーには依存しない

### Testing
- 外部依存のないコードの単体テスト
- 外部依存のあるコードの機能テスト
- クロスレイヤー依存にはモックを使用する必要がある
- テストはブランチカバレッジを達成する必要がある

## Dependencies

### Core Dependencies
- **laravel/framework**: Laravelフレームワーク
- **laravel/tinker**: インタラクティブREPL

### Development Dependencies
- **fakerphp/faker**: テストデータ生成
- **laravel/pail**: ログビューワー
- **laravel/pint**: コードスタイル修正ツール
- **laravel/sail**: Docker開発環境
- **mockery/mockery**: モッキングフレームワーク
- **nunomaduro/collision**: CLIエラーハンドリング
- **phpunit/phpunit**: テストフレームワーク

## Tool Usage Patterns

### Static Analysis
PHPStanはLevel 9で使用され、型安全性を確保し、一般的なエラーを防止します：

```bash
./vendor/bin/phpstan analyse --level=9
```

### Code Style
PHP_CodeSnifferはコーディング標準を強制するために使用されます：

```bash
./vendor/bin/phpcs
```

Laravel Pintはスタイルの問題を自動的に修正するために使用できます：

```bash
./vendor/bin/pint
```

### Testing
PHPUnitはテストに使用され、単体テストと機能テストの別々のスイートがあります：

```bash
# すべてのテストを実行
./vendor/bin/phpunit

# 単体テストのみ実行
./vendor/bin/phpunit --testsuite=Unit

# 機能テストのみ実行
./vendor/bin/phpunit --testsuite=Feature
```

### Database Migrations
Laravelマイグレーションはデータベーススキーマ管理に使用されます：

```bash
php artisan migrate
```

### Seeding
Laravelシーダーはテストデータでデータベースを埋めるために使用されます：

```bash
php artisan db:seed
```
