<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'sales', function ( Blueprint $table ) {
                $table -> float ( 'shipping' ) -> nullable () -> after ( 'percentage_discount' );
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'sales', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'shipping' ] );
            } );
        }
    };
