<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        /**
         * Run the migrations.
         * @return void
         */
        
        public function up () {
            Schema ::table ( 'product_stock', function ( Blueprint $table ) {
                $table -> integer ( 'transfer' ) -> after ( 'sale_unit' ) -> default ( '0' );
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::table ( 'product_stock', function ( Blueprint $table ) {
                $table -> dropColumn ( 'transfer' );
            } );
        }
    };
