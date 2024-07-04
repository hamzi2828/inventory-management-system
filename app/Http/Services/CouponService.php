<?php
    
    namespace App\Http\Services;
    
    use App\Models\Coupon;
    
    class CouponService {
        
        public function all () {
            return Coupon ::get ();
        }
        
        public function save ( $request ): mixed {
            $start_date = date ( 'Y-m-d', strtotime ( $request -> input ( 'start-date' ) ) );
            $end_date   = date ( 'Y-m-d', strtotime ( $request -> input ( 'end-date' ) ) );
            
            return Coupon ::create ( [
                                         'title'       => $request -> input ( 'title' ),
                                         'code'        => $request -> input ( 'code' ),
                                         'discount'    => $request -> input ( 'discount' ),
                                         'start_date'  => $request -> filled ( 'start-date' ) ? $start_date : null,
                                         'end_date'    => $request -> filled ( 'end-date' ) ? $end_date : null,
                                         'description' => $request -> input ( 'description' ),
                                     ] );
        }
        
        public function edit ( $request, $courier ): void {
            $start_date = date ( 'Y-m-d', strtotime ( $request -> input ( 'start-date' ) ) );
            $end_date   = date ( 'Y-m-d', strtotime ( $request -> input ( 'end-date' ) ) );
            
            $courier -> title       = $request -> input ( 'title' );
            $courier -> code        = $request -> input ( 'code' );
            $courier -> discount    = $request -> input ( 'discount' );
            $courier -> start_date  = $request -> filled ( 'start-date' ) ? $start_date : null;
            $courier -> end_date    = $request -> filled ( 'end-date' ) ? $end_date : null;
            $courier -> description = $request -> input ( 'description' );
            $courier -> update ();
        }
        
        public function delete ( $courier ): void {
            $courier -> delete ();
        }
    }