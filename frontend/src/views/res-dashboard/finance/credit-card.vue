<template>
  <section class="finance_page">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 mb-3">
          <h4 class="sec_hd t_primary fw-bold">{{ $t('ResCred.hd1') }}</h4>
        </div>
      </div>
      <form action="">
        <div class="row">
          <div class="col-md-6">
            <div class="input_wrapper my-2">
              <label for="" class="w-100 mb-2">
                <small class="mb-2 d-block">{{ $t("ResCred.label1") }}</small>
                <input type="text" class="form-control" />
              </label>
            </div>
          </div>
          <div class="col-md-6">
            <label for="" class="w-100 my-2">
              <small class="mb-2 d-block">{{ $t("ResCred.label2") }}</small>
              <input type="text" class="form-control" />
            </label>
          </div>
          <div class="col-md-6">
            <label for="" class="w-100 my-2">
              <small class="mb-2 d-block">{{ $t("ResCred.label3") }}</small>
              <input type="text" class="form-control" />
            </label>
          </div>
          <div class="col-md-6">
            <label for="" class="w-100 my-2">
              <small class="mb-2 d-block">{{ $t("ResCred.label4") }}</small>
              <input type="email" class="form-control" />
            </label>
          </div>
          <div class="col-lg-3 col-md-6">
            <label for="" class="w-100 my-2">
              <small class="mb-2 d-block">{{ $t("ResCred.label5") }}</small>
              <input type="text" class="form-control" />
            </label>
          </div>
          <div class="col-lg-3 col-md-6">
            <label for="" class="w-100 my-2">
              <small class="mb-2 d-block">CVC</small>
              <input type="text" class="form-control" />
            </label>
          </div>
          <div class="col-lg-3 col-md-6">
            <label for="" class="w-100 my-2">
              <small class="mb-2 d-block">CPF/CNPJ</small>
              <input type="text" class="form-control" />
            </label>
          </div>
          <div class="col-lg-3 col-md-6">
            <label for="" class="w-100 my-2">
              <small class="mb-2 d-block">{{ $t("ResCred.label6") }}</small>
              <input type="text" class="form-control" />
            </label>
          </div>
          <div class="col-lg-6 col-md-4">
            <label for="" class="w-100 my-2">
              <small class="mb-2 d-block">{{ $t("ResCred.label7") }}</small>
              <input type="text" class="form-control" placeholder="100" />
            </label>
          </div>
          <div class="col-lg-3 col-md-4">
            <label for="" class="w-100 my-2">
              <small class="mb-2 d-block">CEP</small>
              <input type="text" class="form-control" />
            </label>
          </div>
          <div class="col-lg-3 col-md-4">
            <label for="" class="w-100 my-2">
              <small class="mb-2 d-block">{{ $t("ResCred.label8") }}</small>
              <input type="text" class="form-control" />
            </label>
          </div>
          <div class="col-12 my-3">
            <div class="d-flex justify-content-center flex-wrap">
              <div class="img_wrapper me-3" style="max-width: 40px">
                <img
                  src="../../../assets/images/Visa.png"
                  alt=""
                  class="img-fluid"
                />
              </div>
              <div class="img_wrapper me-3" style="max-width: 40px">
                <img
                  src="../../../assets/images/Visa.png"
                  alt=""
                  class="img-fluid"
                />
              </div>
              <div class="img_wrapper me-3" style="max-width: 40px">
                <img
                  src="../../../assets/images/Visa.png"
                  alt=""
                  class="img-fluid"
                />
              </div>
              <div class="img_wrapper me-3" style="max-width: 40px">
                <img
                  src="../../../assets/images/Visa.png"
                  alt=""
                  class="img-fluid"
                />
              </div>
              <div class="img_wrapper me-3" style="max-width: 40px">
                <img
                  src="../../../assets/images/Visa.png"
                  alt=""
                  class="img-fluid"
                />
              </div>
              <div class="img_wrapper me-3" style="max-width: 40px">
                <img
                  src="../../../assets/images/Visa.png"
                  alt=""
                  class="img-fluid"
                />
              </div>
            </div>
            <div class="d-flex flex-wrap flex-sm-nowrap justify-content-around mt-4 mx-auto">
              <button
                class="
                  rounded
                  px-2
                  w-50
                  py-2
                  text-muted
                  bg-transparent
                  border
                  focus_primary
                  me-sm-2
                  me-1
                  mb-sm-0
                  mb-3
                "
                type="button"
              >
                {{ $t("ResCred.btn1") }}
              </button>
              <button
                class="
                  border-0
                  rounded
                  px-2
                  w-50
                  py-2
                  text-light
                  bg_primary
                  focus_primary
                "
                type="button"
              >
                {{ $t("ResCred.btn2") }}
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
</template>

<script>
export default {
  name: "CreditCard",
  title: "Credit Card | Dashboard",
};
</script>

<style>
</style>