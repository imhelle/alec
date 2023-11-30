from typing import Union

import scipy
import json
from scipy.stats import weibull_min
import autograd.numpy as np
import pandas as pd

import os

from lifelines import WeibullFitter, KaplanMeierFitter, ExponentialFitter, NelsonAalenFitter
from lifelines.fitters import ParametricUnivariateFitter
from lifelines.utils import restricted_mean_survival_time as rmst, qth_survival_time as qst
from scipy.stats import kstest, cramervonmises, uniform

#custom
from app.utils import *
from app.models import *

  
def overmortality(T: Union[Cohort, list]):

    if type(T) == Cohort:
        x = T.graph.x
        y = T.graph.y
        n = T.graph.n
        T = convert_to_lifetimes(x, y, n)  
        
    return {
        "overmortality": overmortality_pipe(T),
    }

def overmortality_pipe(T: list, alpha=0.01):

    pval = overmortality_permutation_test(T, 1000)
    verdict = ("false", "true")[pval > alpha]
    return {"verdict": verdict, "pval":pval}
    
def overmortality_permutation_test(T, m=1000):
    n_steps = np.unique(T).shape[0]
    dS = compute_ds(T, T)[:-1]
    N = len(T)

    #Fit models to the sample
    wf = WeibullFitter().fit(T)
    l, k = wf.lambda_, wf.rho_

    ggf = GompertzFitter(T).fit(T)
    A, B = ggf.nu_, ggf.b_

    #overmortality_test
    tw, tg = 0, 0
    for _ in range(m):
        #draw samples from the target models
        wsample = l * np.random.weibull(k, N)
        gsample = generate_gompertz_sample(A, B, np.max(T), n=N)
        #compute their derivatives
        dSw = compute_ds(wsample, T)
        dSg = compute_ds(gsample, T)
        
        if dS.max() > dSw.max():
            tw += 1
        if dS.max() > dSg.max():
            tg += 1
    wpval = 1 - tw/m
    gpval = 1 - tg/m
    # print(wpval, gpval)
    geom_mean = np.sqrt(wpval * gpval)
    return geom_mean
    
def compute_ds(sample, recording_times):
    bins = np.sort(np.unique(recording_times))
    freqs, bins = np.histogram(sample, bins)
    dS = freqs / np.diff(bins)
    return dS
