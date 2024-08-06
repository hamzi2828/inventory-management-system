<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Support\Facades\DB;
    
    class Product extends Model {
        use HasFactory;
        use SoftDeletes;
        
        protected $guarded = [];
        
        public function scopeProductsByBranch ( $query ) {
            $query -> whereIn ( 'id', function ( $query ) {
                $query -> select ( 'product_id' ) -> from ( 'product_stock' ) -> where ( [ 'branch_id' => auth () -> user () -> branch_id ] );
            } );
        }
        
        public function scopeActive ( $query ) {
            $query -> where ( [ 'status' => '1' ] );
        }
        
        public function logs () {
            return $this -> morphMany ( Log::class, 'logable' );
        }
        
        public function manufacturer () {
            return $this -> belongsTo ( Manufacturer::class );
        }
        
        public function category () {
            return $this -> belongsTo ( Category::class );
        }
        
        public function term () {
            return $this -> hasOne ( ProductTerm::class );
        }
        
        public function productTitle () {
            $title = '';
            if ( !empty( trim ( $this -> barcode ) ) )
                $title .= $this -> barcode . ' - ';
            
            $title .= $this -> title;
            
            if ( !empty( $this -> term -> term -> attribute ) )
                $title .= ' ' . $this -> term -> term -> attribute -> title;
            
            if ( !empty( $this -> term ) )
                $title .= ' ' . $this -> term -> term -> title;
            
            return $title;
        }
        
        public function productTitleWithoutBarcode () {
            $title = '';
            
            $title .= $this -> title;
            
            if ( !empty( $this -> term -> term -> attribute ) )
                $title .= ' ' . $this -> term -> term -> attribute -> title;
            
            if ( !empty( $this -> term ) )
                $title .= ' ' . $this -> term -> term -> title;
            
            return $title;
        }
        
        public function productTitleWithSku () {
            return $this -> sku . ' - ' . $this -> title;
        }
        
        public function all_stocks () {
            return $this -> hasMany ( ProductStock::class );
        }
        
        public function stocks () {
            return $this -> hasMany ( ProductStock::class ) -> where ( [ 'branch_id' => auth () -> user () -> branch_id ] ) -> whereIn ( 'stock_id', function ( $query ) {
                $query -> select ( 'id' ) -> from ( 'stocks' ) -> where ( [ 'deleted_at' => null ] );
            } );
        }
        
        public function available_quantity () {
            $stock               = $this -> stock_quantity ();
            $sold                = $this -> sold_quantity ();
            $issued              = $this -> issued_quantity ();
            $returned            = $this -> returned_quantity ();
            $adjustment_decrease = $this -> adjustment_decrease ();
            $damage_loss         = $this -> damage_loss ();
            
            return ( $stock - $sold - $issued - $returned - $adjustment_decrease - $damage_loss );
        }
        
        public function stock_quantity () {
            $branch_id = ( request () -> has ( 'branch-id' ) && request () -> filled ( 'branch-id' ) ) ? request ( 'branch-id' ) : auth () -> user () -> branch_id;
            
            return $this -> hasMany ( ProductStock::class )
                -> where ( [ 'branch_id' => $branch_id ] )
                -> whereIn ( 'stock_id', function ( $query ) {
                    $query -> select ( 'id' ) -> from ( 'stocks' ) -> whereNull ( 'deleted_at' );
                } )
                -> when ( request ( 'vendor-id' ), function ( $query ) {
                    $query -> whereIn ( 'stock_id', function ( $query ) {
                        $query -> select ( 'id' ) -> from ( 'stocks' ) -> where ( 'vendor_id', '=', request ( 'vendor-id' ) );
                    } );
                } )
                -> sum ( 'quantity' );
        }
        
        public function issued_quantity () {
            $branch_id = ( request () -> has ( 'branch-id' ) && request () -> filled ( 'branch-id' ) ) ? request ( 'branch-id' ) : auth () -> user () -> branch_id;
            
            return $this -> hasMany ( IssuedProducts::class ) -> whereIn ( 'issuance_id', function ( $query ) use ( $branch_id ) {
                $query -> select ( 'id' ) -> from ( 'issuance' ) -> where ( [
                                                                                'from_branch' => $branch_id,
                                                                                'deleted_at'  => null
                                                                            ] );
            } ) -> sum ( 'quantity' );
        }
        
        public function return_customer () {
            if ( request () -> has ( 'branch-id' ) && request () -> filled ( 'branch-id' ) ) {
                $branch_id = request ( 'branch-id' );
                
                return $this
                    -> hasMany ( ProductStock::class )
                    -> whereIn ( 'stock_id', function ( $query ) use ( $branch_id ) {
                        $query
                            -> select ( 'id' )
                            -> from ( 'stocks' )
                            -> where ( [ 'type' => 'customer-return' ] )
                            -> where ( [ 'branch_id' => $branch_id ] );
                    } )
                    -> sum ( 'quantity' );
            }
            
            $branch_id = auth () -> user () -> branch_id;
            return $this
                -> hasMany ( ProductStock::class )
                -> whereIn ( 'stock_id', function ( $query ) use ( $branch_id ) {
                    $query
                        -> select ( 'id' )
                        -> from ( 'stocks' )
                        -> where ( [ 'stock_type' => 'customer-return', 'deleted_at' => null ] )
                        -> where ( [ 'branch_id' => $branch_id ] );
                } )
                -> sum ( 'quantity' );
        }
        
        public function returned_quantity () {
            if ( request () -> has ( 'branch-id' ) && request () -> filled ( 'branch-id' ) ) {
                $branch_id = request ( 'branch-id' );
                
                return $this -> hasMany ( StockReturnProduct::class ) -> whereIn ( 'stock_return_id', function ( $query ) use ( $branch_id ) {
                    $query -> select ( 'id' ) -> from ( 'stock_returns' ) -> where ( [ 'type' => 'vendor-return' ] ) -> whereIn ( 'user_id', function ( $query ) use ( $branch_id ) {
                        $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [
                                                                                     'branch_id' => $branch_id
                                                                                 ] );
                    } );
                } ) -> sum ( 'quantity' );
            }
            
            $branch_id = auth () -> user () -> branch_id;
            return $this -> hasMany ( StockReturnProduct::class ) -> whereIn ( 'stock_return_id', function ( $query ) use ( $branch_id ) {
                $query -> select ( 'id' ) -> from ( 'stock_returns' ) -> where ( [
                                                                                     'type'       => 'vendor-return',
                                                                                     'deleted_at' => null
                                                                                 ] ) -> whereIn ( 'user_id', function ( $query ) use ( $branch_id ) {
                    $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => $branch_id ] );
                } );
            } ) -> sum ( 'quantity' );
        }
        
        public function adjustment_decrease () {
            if ( request () -> has ( 'branch-id' ) && request () -> filled ( 'branch-id' ) ) {
                $branch_id = request ( 'branch-id' );
                
                return $this -> hasMany ( StockReturnProduct::class ) -> whereIn ( 'stock_return_id', function ( $query ) use ( $branch_id ) {
                    $query -> select ( 'id' ) -> from ( 'stock_returns' ) -> where ( [ 'type' => 'adjustment-decrease' ] ) -> whereIn ( 'user_id', function ( $query ) use ( $branch_id ) {
                        $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => $branch_id ] );
                    } );
                } ) -> sum ( 'quantity' );
            }
            
            $branch_id = auth () -> user () -> branch_id;
            return $this -> hasMany ( StockReturnProduct::class ) -> whereIn ( 'stock_return_id', function ( $query ) use ( $branch_id ) {
                $query -> select ( 'id' ) -> from ( 'stock_returns' ) -> where ( [
                                                                                     'type'       => 'adjustment-decrease',
                                                                                     'deleted_at' => null
                                                                                 ] ) -> whereIn ( 'user_id', function ( $query ) use ( $branch_id ) {
                    $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => $branch_id ] );
                } );
            } ) -> sum ( 'quantity' );
        }
        
        public function damage_loss () {
            if ( request () -> has ( 'branch-id' ) && request () -> filled ( 'branch-id' ) ) {
                $branch_id = request ( 'branch-id' );
                
                return $this -> hasMany ( StockReturnProduct::class ) -> whereIn ( 'stock_return_id', function ( $query ) use ( $branch_id ) {
                    $query -> select ( 'id' ) -> from ( 'stock_returns' ) -> where ( [ 'type' => 'damage-loss-stock' ] ) -> whereIn ( 'user_id', function ( $query ) use ( $branch_id ) {
                        $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => $branch_id ] );
                    } );
                } ) -> sum ( 'quantity' );
            }
            
            $branch_id = auth () -> user () -> branch_id;
            return $this -> hasMany ( StockReturnProduct::class ) -> whereIn ( 'stock_return_id', function ( $query ) use ( $branch_id ) {
                $query -> select ( 'id' ) -> from ( 'stock_returns' ) -> where ( [
                                                                                     'type'       => 'damage-loss-stock',
                                                                                     'deleted_at' => null
                                                                                 ] ) -> whereIn ( 'user_id', function ( $query ) use ( $branch_id ) {
                    $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => $branch_id ] );
                } );
            } ) -> sum ( 'quantity' );
        }
        
        public function sold_quantity () {
            if ( request () -> has ( 'branch-id' ) && request () -> filled ( 'branch-id' ) ) {
                $branch_id = request ( 'branch-id' );
                
                return $this
                    -> hasMany ( SaleProducts::class )
                    -> whereIn ( 'sale_id', function ( $query ) use ( $branch_id ) {
                        $query
                            -> select ( 'id' )
                            -> from ( 'sales' )
                            -> where ( [ 'sale_closed' => '1', 'refunded' => '0', 'deleted_at' => null ] )
                            -> whereIn ( 'user_id', function ( $query ) use ( $branch_id ) {
                                $query
                                    -> select ( 'id' )
                                    -> from ( 'users' )
                                    -> where ( [ 'branch_id' => $branch_id ] );
                            } );
                    } )
                    -> when ( request ( 'vendor-id' ), function ( $query ) {
                        $query -> whereIn ( 'stock_id', function ( $query ) {
                            $query
                                -> select ( 'id' )
                                -> from ( 'product_stock' )
                                -> whereIn ( 'stock_id', function ( $query ) {
                                    $query
                                        -> select ( 'id' )
                                        -> from ( 'stocks' )
                                        -> where ( [ 'vendor_id' => request ( 'vendor-id' ) ] );
                                } );
                        } );
                    } )
                    -> sum ( 'quantity' );
            }
            
            else if ( request () -> routeIs ( 'dashboard' ) && count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) > 0 ) {
                $branch_id = auth () -> user () -> branch_id;
                
                return $this -> hasMany ( SaleProducts::class ) -> whereIn ( 'sale_id', function ( $query ) use ( $branch_id ) {
                    $query -> select ( 'id' ) -> from ( 'sales' ) -> where ( [
                                                                                 'sale_closed' => '1',
                                                                                 'refunded'    => '0',
                                                                                 'deleted_at'  => null
                                                                             ] ) -> whereIn ( 'user_id', function ( $query ) use ( $branch_id ) {
                        $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => $branch_id ] );
                    } );
                } ) -> sum ( 'quantity' );
            }
            
            $branch_id = auth () -> user () -> branch_id;
            return $this -> hasMany ( SaleProducts::class ) -> whereIn ( 'sale_id', function ( $query ) use ( $branch_id ) {
                $query -> select ( 'id' ) -> from ( 'sales' ) -> where ( [
                                                                             'sale_closed' => '1',
                                                                             'refunded'    => '0',
                                                                             'deleted_at'  => null
                                                                         ] ) -> whereIn ( 'user_id', function ( $query ) use ( $branch_id ) {
                    $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => $branch_id ] );
                } );
            } ) -> sum ( 'quantity' );
        }
        
        public function refund_quantity () {
            $branch_id = auth () -> user () -> branch_id;
            return $this -> hasMany ( SaleProducts::class ) -> whereIn ( 'sale_id', function ( $query ) use ( $branch_id ) {
                $query -> select ( 'id' ) -> from ( 'sales' ) -> where ( [
                                                                             'refunded'   => '1',
                                                                             'deleted_at' => null
                                                                         ] ) -> whereIn ( 'user_id', function ( $query ) use ( $branch_id ) {
                    $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => $branch_id ] );
                } );
            } ) -> sum ( 'quantity' );
        }
        
        public function customer_price () {
            return $this -> hasOne ( CustomerProductPrice::class ) -> where ( 'customer_id', '=', request ( 'customer_id' ) );
        }
        
        public function stock_value_tp_wise () {
            $issued   = $this -> issued_stock ();
            $returned = $this -> returned_stock ();
            $sold     = $this -> sold_stock ();
            
            $ids = array_merge ( $issued, $returned, $sold );
            $net = 0;
            
            $stocks = $this -> all_stocks () -> whereNotIn ( 'stock_id', $ids );
            
            if ( request () -> filled ( 'branch-id' ) ) {
                $stocks = $stocks -> where ( [ 'branch_id' => request () -> input ( 'branch-id' ) ] );
            }
            else {
                $stocks = $stocks -> where ( [ 'branch_id' => auth () -> user () -> branch_id ] );
            }
            
            $stocks = $stocks -> get ();
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock ) {
                    $net += $stock -> tp_unit;
                }
            }
            
            return count ( $stocks ) > 0 ? ( $net / count ( $stocks ) ) : 0;
        }
        
        public function stock_value_sale_wise () {
            $issued   = $this -> issued_stock ();
            $returned = $this -> returned_stock ();
            $sold     = $this -> sold_stock ();
            
            $ids = array_merge ( $issued, $returned, $sold );
            $net = 0;
            
            $stocks = $this -> all_stocks () -> whereNotIn ( 'stock_id', $ids );
            
            if ( request () -> filled ( 'branch-id' ) ) {
                $stocks = $stocks -> where ( [ 'branch_id' => request () -> input ( 'branch-id' ) ] );
            }
            else {
                $stocks = $stocks -> where ( [ 'branch_id' => auth () -> user () -> branch_id ] );
            }
            
            $stocks = $stocks -> get ();
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock ) {
                    $net += $stock -> sale_unit;
                }
            }
            return count ( $stocks ) > 0 ? ( $net / count ( $stocks ) ) : 0;
        }
        
        public function issued_stock () {
            return $this -> hasMany ( IssuedProducts::class ) -> pluck ( 'stock_id' ) -> toArray ();
        }
        
        public function returned_stock () {
            return $this -> hasMany ( StockReturnProduct::class ) -> pluck ( 'stock_id' ) -> toArray ();
        }
        
        public function sold_stock () {
            return $this -> available_quantity () > 0 ? [] : $this -> hasMany ( SaleProducts::class ) -> pluck ( 'stock_id' ) -> toArray ();
        }
        
        public function avatar () {
            return !empty( trim ( $this -> image ) ) ? $this -> image : '';
        }
        
        public function product_images (): HasMany {
            return $this -> hasMany ( ProductImage::class );
        }
        
        public function variations (): HasMany {
            return $this -> hasMany ( Product::class, 'parent_id' );
        }
        
        public function product_variations (): HasMany {
            return $this -> hasMany ( ProductVariation::class );
        }

        public function reviews()
            {
                return $this->hasMany(ProductUserReview::class);
            }

    }
